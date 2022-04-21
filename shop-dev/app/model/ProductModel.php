<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class ProductModel extends Model{

    public static function getProductInfo($uri){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_detail b', 'a.id = b.product_id', 'left')
            ->field('a.id, a.name, a.uri, b.short_desc, b.long_desc')
        ->where(['a.uri' => $uri])
        ->find();  
        return $ret;
    }

    public static function getProductImg($uri){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_img b', 'a.id = b.product_id', 'left')
            ->field('b.name, b.uri, b.sort, b.product_id')
        ->where(['a.uri' => $uri])
        ->select();  
        return $ret;
    }
}
