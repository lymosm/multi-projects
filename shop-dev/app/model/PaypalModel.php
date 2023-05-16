<?php
namespace app\model;

use think\Model;
use think\facade\Db;
use Lymos\Paypal\paypal;
use think\facade\Config;

class PaypalModel extends Model{

    public static function payment($params){
        $config = Config::get('app.paypal');
        $client_id = $config['client_id'];
        $client_secret = $config['client_secret'];
        $obj = new paypal;
        if($config['test_mode']){
            $obj->setSandbox(true);
        }
        
        $obj->auth($client_id, $client_secret);
        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => $params['total_price']
                ]
                ]
            ]
            ];
        $ret = $obj->createOrder(json_encode($data));
        $ret = json_decode($ret, true);
        if(isset($ret['links'])){
            return ['redirect_url' => $ret['links'][1]['href']];
        }else{
            return false;
        }
        // return data url https://www.sandbox.paypal.com/checkoutnow?token=2K302290X2821480B is to pay
    }
}
