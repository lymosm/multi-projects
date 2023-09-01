<?php 
namespace app\controller;
use app\BaseController;
use think\facade\View;

class Error extends BaseController{

    public static function e404(){
        return View::fetch('home/template/404');
    }

}