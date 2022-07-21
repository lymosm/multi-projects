<?php
use Lymos\Stripe\stripe;

require '../vendor/autoload.php';

$key = 'sk_test_DiSWYAGGrHqwawYjWopzklpS00ohKhFRhz';
$obj = new stripe;
$data = [
    'amount' => 20,
    'currency' => 'usd',
    'source' => 'src_1LIO5wCDkC2rJVyNDLDo0DQo',
    'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',
    ];
$options = [
        'header' => [
            'Authorization: Bearer ' . $key
        ]
        ];
$obj->charge($data, $options);