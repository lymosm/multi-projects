<?php
namespace Lymos\Paypal\api;

use Lymos\Paypal\config\config;
use Lymos\Paypal\lib\request;

class Order{

    public $uri = 'v2/checkout/orders';
    public $config = [];
    public $is_sandbox = false;

    public function __construct(){
        $this->config = new config;
    }

    public function setSandbox($status){
        $this->is_sandbox = $status;
    }

    public function create($access_token, $data, $options = []){
        if($this->is_sandbox){
            $base_url = $this->config->sandbox_base_url;
        }else{
            $base_url = $this->config->base_url;
        }
            
        $url = $base_url . $this->uri;
        $requ = new request;
        $options['header'] = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        ];

        $ret = $requ->post($url, $data, $options);
        return $ret;
    }

}