<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class ProductModel extends Model{

    public static function getProductInfo($uri){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_detail b', 'a.id = b.product_id', 'left')
            ->field('a.id, a.name, a.uri, b.short_desc, b.long_desc, b.price')
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

    public static function getProductRecommand($uri = ''){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_img b', 'a.id = b.product_id', 'left')
            ->field('a.name, a.uri as product_uri, b.uri as img_uri, b.sort, b.product_id')
        ->limit(5)
        ->order('a.id desc')
        ->select();  
        return $ret;
    }
}