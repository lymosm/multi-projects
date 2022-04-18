<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class Widget extends Model{

    public static function getHomeLoopBanner(){
        $type = 'home-top';
        $ret = Db::name('loop_banner')->field('*')
            ->where(['type' => $type])->select();

        $html = '<div class="ls-home-top" id="ls-home-top">';
        foreach($ret as $rs){
            $html .= '<div>';
            if($rs['link']){
                $html .= '<a class="img-link" href="' . $rs['link'] . '">';
            }
            $html .= '<img src="' . $rs['img_uri'] . '">';
            if($rs['btn']){
                $html .= '<a class="ls-btn" href="' . $rs['btn_link'] . '">' . $rs['btn'] . '</a>';
            }
            if($rs['text']){
                $html .= '<div class="ls-home-top-text">' . $rs['text'] . '</div>';
            }
            if($rs['link']){
                $html .= '</a>';
            }
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }


}
