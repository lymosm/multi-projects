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

    public static function getProductListByCate($where, $page, $limit){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_detail b', 'a.id = b.product_id', 'left')
            ->join('product_cate_rela c', 'c.product_id = a.id', 'left')
            ->field('a.id, a.name, a.uri, b.short_desc, b.long_desc, b.price')
            ->where($where)
            ->order('a.id desc')
            ->limit(($page - 1) * $limit, $limit)
            ->select()
            ->toArray();  
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
            ->join('product_detail c', 'a.id = c.product_id', 'left')
            ->field('a.name, a.uri as product_uri, b.uri as img_uri, b.sort, b.product_id, c.price')
        ->where(['b.is_main' => 1])
        ->limit(5)
        ->order('a.id desc')
        ->select();  
        return $ret;
    }

    public static function getProductById($id){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_detail c', 'a.id = c.product_id', 'left')
            ->field('a.name, c.price, a.id, a.uri')
        ->where(['a.id' => $id])
        ->find();  
        return $ret;
    }
}
