<?php
namespace Lymos\Stripe\api;

use Lymos\Stripe\config\config;
use Lymos\Stripe\lib\request;

class charge{

    public $uri = 'v1/charges';
    public $config = [];

    public function __construct(){
        $this->config = new config;
    }

    public function chargeSend($key, $data, $options = []){
        $url = $this->config->base_url . $this->uri;
        $requ = new request;
        $ret = $requ->post($url, $data, $options);
        return $ret;
    }

}