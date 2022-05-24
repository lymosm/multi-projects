<?php
namespace app\model;

use think\Model;
use think\facade\Db;

class RequestModel extends Model{

    public $info;
    public $error;
    
    public static function get($url, $option, $is_return_arr = false){
        $res = self::_request($url, 'GET', [], $option, $is_return_arr);
        return $res;
    }

    public static function post($url, $data = [], $option = [], $is_return_arr = false){
        $res = self::_request($url, 'POST', $data, $option, $is_return_arr);
        return $res;
    }

    private static function _request($url, $method = "GET", $data = [], $option = [], $is_return_arr = false){
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ];
        if(strtoupper($method) == 'POST'){
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $data;
        }
        $options = array_merge($options, $option);
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = curl_exec($ch);
        self::$info = curl_getinfo($ch);
        self::$error = [
                'error' => curl_error($ch),
                'errno' => curl_errno($ch)
        ];
        curl_close($ch);
        if($is_return_arr){
            return json_decode($res);
        }
        return $res;
    }
}
