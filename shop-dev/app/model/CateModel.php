<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class CateModel extends Model{

    public static function getList(){
        $list = Db::name('cate')->alias('a')
            ->join('cate_rela b', 'a.id = b.cate_id', 'left')
           // ->join('cate_rela c', 'a.id = c.parent_id', 'left')
            ->field('*')
            ->select();
        
        $data = self::make_tree($list);
        error_log(print_r($data, true) . "\r\n", 3, '/mnt/d/www/debug.log');

    }

    /**
     * 递归实现无限极分类
     * @param $array 分类数据
     * @param $pid 父ID
     * @param $level 分类级别
     * @return $list 分好类的数组 直接遍历即可 $level可以用来遍历缩进
     */
    public static function getTree($array, $pid=0, $level = 0){
        //声明静态数组,避免递归调用时,多次声明导致数组覆盖
        static $list = [];
        foreach ($array as $key => $value){
            //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
            if ($value['parent_id'] == $pid){
                //父节点为根节点的节点,级别为0，也就是第一级
                $value['level'] = $level;
                //把数组放到list中
                $list['child'][] = $value;
                //把这个节点从数组中移除,减少后续递归消耗
                unset($array[$key]);
                //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
                self::getTree($array, $value['id'], $level+1);
            }
        }
        return $list;
    }

    /**
     * 把返回的数据集转换成Tree 引用方式
     * @param array $list 要转换的数据集
     * @param string $pk 自增字段（栏目id）
     * @param string $pid parent标记字段
     * @return array
     * @author 
     */
    public static function make_tree($list,$pk='id',$pid='parent_id',$child='_child',$root=0){
        $tree=array();
        $packData=array();
        foreach ($list as $data) {
            $packData[$data[$pk]] = $data;
        }
        foreach ($packData as $key =>$val){
        if($val[$pid]==$root){//代表跟节点
            $tree[]=& $packData[$key];
        }else{
            //找到其父类
            $packData[$val[$pid]][$child][]=& $packData[$key];
        }
        }
        return $tree;
    }
  
    /**
     * 递归方式
     */
    public static function make_tree1($list,$pk='id',$pid='parent_id',$child='_child',$root=0){
        $tree=array();
        foreach($list as $key=> $val){
          if($val[$pid]==$root){
            //获取当前$pid所有子类
              unset($list[$key]);
              if(! empty($list)){
                $child= self::make_tree1($list,$pk,$pid,$child,$val[$pk]);
                if(!empty($child)){
                  $val['_child']=$child;
                }
              }
              $tree[]=$val;
          }
        }
        return $tree;
      }
      
      
  
}
