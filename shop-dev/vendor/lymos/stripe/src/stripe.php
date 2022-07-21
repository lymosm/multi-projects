<?php
namespace Lymos\Stripe;

use Lymos\Stripe\api\charge;


class stripe{

    public $key = '';

    public function key($key){
        $this->key = $key;
        return $this;
    }

    public function charge($data, $options = []){
        $charge = new charge;
        if($this->key){
            $options['userpwd'] = $this->key;
        }
        $options['is_http_build'] = true;
        return $charge->chargeSend($this->key, $data, $options);
    }
}