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
            $html .= '<div class="ls-banner-item">';
            if($rs['link']){
                $html .= '<a class="img-link" href="' . $rs['link'] . '">';
            }
            $html .= '<img src="' . $rs['img_uri'] . '">';
            $has_div = false;
            if($rs['text']){
                if(! $has_div){
                    $html .= '<div class="ls-banner-txt-box">';
                    $has_div = true;
                }
                $html .= '<div class="ls-home-top-text">' . $rs['text'] . '</div>';
            }
            if($rs['btn']){
                if(! $has_div){
                    $html .= '<div class="ls-banner-txt-box">';
                    $has_div = true;
                }
                $html .= '<a class="ls-btn" href="' . $rs['btn_link'] . '">' . $rs['btn'] . '</a>';
            }
            
            if($has_div){
                $html .= '</div>';
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
