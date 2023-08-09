<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class PageModel extends Model{

    public static function getPageCount($where = []){
        $ret = Db::name('user')
            ->alias('a')
            ->join('user_role b', 'a.id = b.user_id', 'left')
            ->join('role c', 'b.role_id = c.id', 'left')
            ->field('count(*) as count')
            ->where($where)
            ->select();  

        return isset($ret[0]['count']) ? $ret[0]['count'] : 0;
    }

    public static function getPageList($where = [], $limit_s = 0, $limit_e = 0){
        $ret = Db::name('user')
            ->alias('a')
            ->join('user_role b', 'a.id = b.user_id', 'left')
            ->join('role c', 'b.role_id = c.id', 'left')
            ->field('a.id, a.account, a.added_date, c.name as role_name')
        ->where($where)
        ->limit($limit_s, $limit_e)
        ->order('a.id desc')
        ->select();  
        return $ret;
    }

    public static function getPageAllById($id){
        $ret = Db::name('user')
        ->alias('a')
        ->join('user_role b', 'a.id = b.user_id', 'left')
        ->field('a.id, a.account, a.added_date, b.role_id')
        ->where(['a.id' => $id])
        ->find();  
        return $ret;
    }
}
