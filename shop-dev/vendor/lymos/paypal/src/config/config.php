<?php
namespace Lymos\Paypal\config;
class config{
    public $base_url;
    public $sandbox_base_url;
    public function __construct(){
        $this->base_url = 'https://api-m.paypal.com/';
        $this->sandbox_base_url = 'https://api-m.sandbox.paypal.com/';
    }
}
