<?php
use Lymos\Paypal\paypal;

require '../vendor/autoload.php';

$client_id = 'AQAcuRuWIEhtkrWZeAUA3ZSIjxNAtom-xlfpJ2gAjVyxItwq5sC7sRK_-aK8rPxnKc27jO-dMHC7EjuR';
$client_secret = 'ELOVxwMOnpq4njtcEyJWhk5gNVlw4YYdZBgbsn9V_PMbJTKscYuN7LG2NBZIVgaFNL_2eyAkm0sqqUAX';
$obj = new paypal;
$obj->setSandbox(true);
$obj->auth($client_id, $client_secret);
$data = [
    'intent' => 'CAPTURE',
    'purchase_units' => [
        [
        'amount' => [
            'currency_code' => 'USD',
            'value' => '10.00'
        ]
        ]
    ]
    ];
$ret = $obj->createOrder(json_encode($data));
// return data url https://www.sandbox.paypal.com/checkoutnow?token=2K302290X2821480B is to pay
print_r($ret);