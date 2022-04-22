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
            ->field('id, session_id, cart_content')
        ->where(['session_id' => $session_id])
        ->find();  
        return $ret;
    }
}
