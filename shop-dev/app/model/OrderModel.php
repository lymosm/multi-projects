<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class OrderModel extends Model{

    public static function addOrder($user, $product_list, $price_obj){
        $date = date('Y-m-d H:i:s');
        $order_num = self::genOrderNum();
        $order_data = [
            'order_num' => $order_num,
            'added_by' => $user['uid'],
            'added_date' => $date
        ];
        // transtion 
        Db::startTrans();
        $order_id = Db::name('order')->insertGetId($order_data);
        if(! $order_id){
            Db::rollback();
            return false;
        }

        $order_user = [
            'order_id' => $order_id,
            'user_id' => $user['uid'],
            'session_id' => $user['session_id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'address' => $user['address'],
            'phone' => $user['phone']
        ];
        $order_user_status = Db::name('order_user')->insert($order_user);
        if($order_user_status === false){
            Db::rollback();
            return false;
        }

        foreach($product_list as $rs){
            $order_product = [
                'order_id' => $order_id,
                'product_id' => $rs['product_id'],
                'product_name' => $rs['product_name'],
                'price' => $rs['price'],
                'qty' => $rs['qty'],
                'item_price' => $rs['item_price'],
            ];
            $order_product_status = Db::name('order_product')->insert($order_product);
            if($order_product_status === false){
                Db::rollback();
                return false;
            }
        }
        
        $order_price = [
            'order_id' => $order_id,
            'total_price' => $price_obj['total_price'],
        ];
        $order_user_status = Db::name('order_price')->insert($order_price);
        if($order_user_status === false){
            Db::rollback();
            return false;
        }

        // commit
        $commit = Db::commit();
        if($commit === false){
            Db::rollback();
            return false;
        }

        return $order_num;
    }

    private static function genOrderNum(){
        return uniqid();
    }

    public static function getOrderByNum($num){
        $where = [
            'a.order_num' => $num
        ];
        $product_list = Db::name('order')->alias('a')
            ->join('order_product b', 'a.id = b.order_id', 'left')
            ->field('b.order_id, b.product_id, b.product_name, b.price, b.qty, b.item_price, a.order_num')
            ->where($where)
            ->select();
        $user = Db::name('order')->alias('a')
            ->join('order_user b', 'a.id = b.order_id', 'left')
            ->field('b.order_id, b.session_id, b.country, b.state, b.city, b.first_name, b.last_name, b.email, b.address, b.phone')
            ->where($where)
            ->find();
        $price = Db::name('order')->alias('a')
            ->join('order_price b', 'a.id = b.order_id', 'left')
            ->field('b.order_id, b.discount_price, b.total_price, a.order_num, a.paid_type, a.added_date')
            ->where($where)
            ->find();
        return [
            'product_list' => $product_list,
            'user' => $user,
            'price' => $price
        ];
    }
}