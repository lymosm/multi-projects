<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use think\response\Json;
use app\model\Widget;
use app\model\CartModel;
use app\model\CheckoutModel;
use app\model\OrderModel;

class Checkout extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function index(){
		$cart = CartModel::getCartData($this->session_id);
		View::assign('title', 'Checkout');
		if(! $cart){
			return View::fetch('checkout_empty');
		}
		$cart_content = json_decode($cart['cart_content'], true);
		
		View::assign('product_list', $cart_content['product_list']);
		View::assign('price_obj', $cart_content['price_obj']);
		return View::fetch('checkout');
	}

	/**
     * [
     *  'product_list',
     *  'price_detail' 
     * ]
     */
    public function saveCheckout($cart){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
        $first_name = addslashes(trim(Request::param('first_name')));
		$last_name = addslashes(trim(Request::param('last_name')));
		$phone = addslashes(trim(Request::param('phone')));
		$email = addslashes(trim(Request::param('email')));
		$address = addslashes(trim(Request::param('address')));
        
		if(! $email || ! $first_name){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$user = [
			'first_name' => $first_name,
			'last_name' => $last_name,
			'phone' => $phone,
			'email' => $email,
			'address' => $address,
			'session_id' => $this->session_id
		];

		$cart = CartModel::getCartData($this->session_id);
	
		if(! $cart){
			$ret['msg'] = 'Empty Cart';
			return json($ret);
		}
		$cart_content = json_decode($cart['cart_content'], true);
		$product_list = $cart_content['product_list'];
		$price_obj = $cart_content['price_obj'];

		$status = OrderModel::addOrder($user, $product_list, $price_obj);
		if($price_obj['need_payment']){
			// redirect
		}

    }
}
