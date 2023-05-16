<?php
namespace Lymos\Stripe\lib;

class request{

    public $error;
    public $errno;
    public $info;

    public function curl($url, $method, $data = [], $options = []){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($method == 'POST'){
            if(isset($options['is_http_build'])){
                $data = http_build_query($data);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if(isset($options['header'])){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']);
        }
        if(isset($options['userpwd'])){
            curl_setopt($ch, CURLOPT_USERPWD, $options['userpwd']);
        }

        $ret = curl_exec($ch);
        $this->info = curl_getinfo($ch);
        $this->error = curl_error($ch);
        $this->errno = curl_errno($ch);
        curl_close($ch);
        return $ret;
    }

    public function get($url, $options = []){
        return $this->curl($url, 'GET', [], $options);
    }

    public function post($url, $data = [], $options = []){
        return $this->curl($url, 'POST', $data, $options);
    }
}