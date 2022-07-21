<?php
namespace Lymos\Paypal\api;

use Lymos\Paypal\config\config;
use Lymos\Paypal\lib\request;

class Paypal{

    public $uri = 'v1/charges';
    public $config = [];

    public function __construct(){
        $this->config = new config;
    }

    public function chargeSend($key, $data, $options = []){
        $url = $this->config->base_url . $this->uri;
        $requ = new request;
        $ret = $requ->post($url, $data, $options);
        echo $ret;
        return $ret;
    }

}