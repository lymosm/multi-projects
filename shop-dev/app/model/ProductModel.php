<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class ProductModel extends Model{

    public static function getProductInfo($uri){
        $ret = Db::name('product')->field('id, name, uri')
        ->where(['uri' => $uri])
        ->find();  
        return $ret;
    }


}
