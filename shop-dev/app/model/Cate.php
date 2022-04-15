<?php
namespace app\model;

use think\Model;

class Cate extends Model{

    public static function getList(){
        $list = User::where('id', '>', 0)
            ->select();
        return $list;
    }
}
