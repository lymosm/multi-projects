<?php
namespace Lymos\Paypal;

use Lymos\Paypal\lib\auth;
use Lymos\Paypal\api\order;


class paypal{

    public $access_token = '';
    public $is_sandbox = false;

    public function key($key){
        $this->key = $key;
        return $this;
    }

    public function setSandbox($status){
        $this->is_sandbox = $status;
    }

    public function auth($client_id, $client_secret){
        $auth = new auth;
        $auth->authentication($client_id, $client_secret, $this->is_sandbox);
        $token = $auth->getAuth();
        $this->access_token = $token['access_token'];
        return $this->access_token;
    }

    public function createOrder($data){
        $order = new order;
        $order->setSandbox($this->is_sandbox);
        return $order->create($this->access_token, $data);
    }
}