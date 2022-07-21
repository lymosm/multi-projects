<?php
namespace Lymos\Paypal\lib;

use Lymos\Paypal\config\config;
use Lymos\Paypal\lib\request;

class auth{

    public $uri = 'v1/oauth2/token';
    public $config = [];
    private $auth_data = [];

    public function __construct(){
        $this->config = new config;
    }

    public function authentication($client_id, $client_secret, $is_sandbox = false){
        if($is_sandbox){
            $base_url = $this->config->sandbox_base_url;
        }else{
            $base_url = $this->config->base_url;
        }
            
        $url = $base_url . $this->uri;
        $requ = new request;
        $data = [
            'grant_type' => 'client_credentials'
        ];
        $options = [
            'userpwd' => $client_id . ':' . $client_secret,
            'header' => ['Content-Type: application/x-www-form-urlencoded'],
            'is_http_build' => true
        ];
        $ret = $requ->post($url, $data, $options);
        $this->auth_data = json_decode($ret, true);
        return $ret;
    }

    public function getAuth(){
        return $this->auth_data;
    }

}