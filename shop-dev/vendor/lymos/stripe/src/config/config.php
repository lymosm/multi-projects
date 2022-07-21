<?php
namespace Lymos\Stripe\config;
class config{
    public $base_url;
    public function __construct(){
        $this->base_url = 'https://api.stripe.com/';
    }
}
