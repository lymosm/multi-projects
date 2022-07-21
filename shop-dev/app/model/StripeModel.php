<?php
namespace app\model;

use think\Model;
use think\facade\Db;
use Lymos\Stripe\stripe;

class StripeModel extends Model{

    public $prod_url = '';
    public $dev_url = '';
    public $mode = 'dev';

    public static function payment($params){
        $config = Config::get('app.stripe');
        $key = $config['key'];
        $obj = new stripe;
        $data = [
            'amount' => $params['total_price'],
            'currency' => 'usd',
            'source' => $params['source'],
           // 'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',
            ];
        $options = [
                'header' => [
                    'Authorization: Bearer ' . $key
                ]
                ];
        $obj->charge($data, $options);
    }

    
}
