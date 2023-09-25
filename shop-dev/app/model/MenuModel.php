<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class MenuModel extends Model{

    public static function getMenuTree(){
        $mm = self::getMainMenu();
        $menu = json_decode($mm['menu'], true);
        $menu_ids = [];
        foreach($menu as $rs){
            if(isset($rs['child'])){
                foreach($rs['child'] as $rss){
                    $menu_ids[] = $rss['id'];
                }
            }
            $menu_ids[] = $rs['id'];
        }

        $menu_items = self::getMenuItems(' a.id in (' . implode(',', $menu_ids) . ')');
        $menu_items = array_column($menu_items, null, 'id');

        return [
            'menu_list' => $menu,
            'menu_items' => $menu_items
        ];
    }

    public static function getMenuItems($where){
        $ret = Db::name('menu_item')
            ->alias('a')
            ->field('a.id, a.name, a.url')
        ->where($where)
        ->select()
        ->toArray();  
        return $ret;
    }

    public static function getMainMenu(){
        $ret = Db::name('menu')
        ->alias('a')
        ->field('a.id, a.name, a.menu')
        ->where(['a.name' => 'main-menu'])
        ->find();  
        return $ret;
    }
}
