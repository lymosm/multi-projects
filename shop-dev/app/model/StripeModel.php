<?php
namespace app\model;

use think\Model;
use think\facade\Db;
use app\Model\RequestModel;

class StripeModel extends Model{

    public $prod_url = '';
    public $dev_url = '';
    public $mode = 'dev';

    public static function payment(){
        if(self::$mode == 'dev'){
            $url = self::$dev_url;
        }else{
            $url = self::$prod_url;
        }
        $ret = RequestModel::post($url);
    }

    
}
