<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class CartModel extends Model{

    /**
     * [
     *  'product_list',
     *  'price_detail' 
     * ]
     */
    public static function getCartData($session_id){
        $ret = Db::name('cart')
            ->field('id, session_id, user_id, cart_content')
        ->where(['session_id' => $session_id])
        ->find();  
        return $ret;
    }

    public static function getCartDataUid($uid){
        $ret = Db::name('cart')
            ->field('id, session_id, user_id, cart_content')
        ->where(['user_id' => $uid])
        ->find();  
        return $ret;
    }

    public static function saveCartData($session_id, $data, $is_update){
        $cart_data = [
            'cart_content' => json_encode($data),
            'session_id' => $session_id,
            'updated_date' => date('Y-m-d H:i:s')
        ];
        if(! $is_update){
            $ret = Db::name('cart')
                ->insert($cart_data);
        }else{
            $ret = Db::name('cart')
            ->where(['session_id' => $session_id])
            ->update($cart_data);
        }   
        return $ret;
    }
}
