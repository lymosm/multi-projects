<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class PageModel extends Model{

    public static function getCount($where = []){
        $ret = Db::name('page')
            ->alias('a')
            ->join('user b', 'b.id = a.added_by', 'left')
            ->field('count(*) as count')
            ->where($where)
            ->select();  

        return isset($ret[0]['count']) ? $ret[0]['count'] : 0;
    }

    public static function getPageByUri($uri){
        $ret = Db::name('page')
        ->alias('a')
        ->field('a.id, a.title, a.uri, a.content')
        ->where(['a.uri' => $uri])
        ->find();  
        return $ret;
    }

    public static function getList($where = [], $limit_s = 0, $limit_e = 0){
        $ret = Db::name('page')
            ->alias('a')
            ->join('user b', 'b.id = a.added_by', 'left')
            ->field('a.id, a.title, a.uri, a.content, b.account as added_by, a.added_date')
        ->where($where)
        ->limit($limit_s, $limit_e)
        ->order('a.id desc')
        ->select();  
        return $ret;
    }

    public static function getPageAllById($id){
        $ret = Db::name('page')
        ->alias('a')
        ->field('a.id, a.title, a.uri, a.content')
        ->where(['a.id' => $id])
        ->find();  
        return $ret;
    }
}
