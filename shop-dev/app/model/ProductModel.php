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
            ->join('attachment c', 'b.attachment_id = c.id', 'left')
            ->field('c.name, c.uri, b.sort, b.product_id')
        ->where(['a.uri' => $uri])
        ->select();  
        return $ret;
    }

    public static function getProductRecommand($uri = ''){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_img b', 'a.id = b.product_id', 'left')
            ->join('attachment d', 'b.attachment_id = d.id', 'left')
            ->join('product_detail c', 'a.id = c.product_id', 'left')
            ->field('a.name, a.uri as product_uri, d.uri as img_uri, b.sort, b.product_id, c.price')
        ->where(['b.is_main' => 1])
        ->limit(5)
        ->order('a.id desc')
        ->select();  
        return $ret;
    }

    public static function getProductCount($where = []){
        $where = array_merge(['b.is_main' => 1], $where);
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_img b', 'a.id = b.product_id', 'left')
            ->join('product_detail c', 'a.id = c.product_id', 'left')
            ->join('product_cate_rela d', 'a.id = d.product_id', 'left')
            ->join('cate e', 'd.cate_id = e.id', 'left')
            ->field('count(*) as count')
        ->where($where)
        ->find();  
        return $ret['count'];
    }

    public static function getProductList($where = [], $limit_s = 0, $limit_e = 0){
        $where = array_merge(['b.is_main' => 1], $where);
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_img b', 'a.id = b.product_id', 'left')
            ->join('product_detail c', 'a.id = c.product_id', 'left')
            ->join('product_cate_rela d', 'a.id = d.product_id', 'left')
            ->join('cate e', 'd.cate_id = e.id', 'left')
            ->join('attachment f', 'f.id = b.attachment_id', 'left')
            ->field('a.name, a.uri as product_uri, f.uri as img_uri, e.cate_name, a.id, b.product_id, c.price')
        ->where($where)
        ->limit($limit_s, $limit_e)
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

    public static function getProductAllById($id){
        $ret = Db::name('product')
            ->alias('a')
            ->join('product_detail c', 'a.id = c.product_id', 'left')
            ->join('product_cate_rela d', 'a.id = d.product_id', 'left')
            ->field('a.name, c.price, a.id, a.uri, d.cate_id, c.short_desc, c.long_desc')
        ->where(['a.id' => $id])
        ->find();  
        return $ret;
    }
}
