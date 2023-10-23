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
use app\model\PaypalModel;
use app\model\StripeModel;

class Checkout extends BaseController
{
	private $_uid = 0;
	
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

	public function result($order){
		View::assign('title', 'Result');
		if(! trim($order)){
			return View::fetch('no_order');
		}
		$data = OrderModel::getOrderByNum($order);

		View::assign('product_list', $data['product_list']);
		View::assign('order_user', $data['user']);
		View::assign('price', $data['price']);
		return View::fetch('result');
	}

	/**
     * [
     *  'product_list',
     *  'price_detail' 
     * ]
     */
    public function saveCheckout(){
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
		$source = addslashes(trim(Request::param('stripe_source')));
		$payment_type_param = addslashes(trim(Request::param('payment_type')));
        
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
			'session_id' => $this->session_id,
			'uid' => $this->userid
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
		if($status === false){
			$ret['msg'] = 'Add Cart Failed';
			return json($ret);
		}
		$this->_removeCart($this->session_id);
		$order_id = $status;
		$need_payment = $price_obj['need_payment'];
		$res = [
			'redirect_url' => '/Checkout/result/order/' . $order_id
		];

		// debug
		/*
		$ret['code'] = 1;
		$ret['data'] = ['redirect' => $res['redirect_url']];
		return json($ret);
*/

		if($need_payment){
			if($payment_type_param){
				$payment_type = $payment_type_param;
			}else{
				$payment_type = $price_obj['payment_type'];
			}
			
			switch($payment_type){
				case 'paypal':
					$res = PaypalModel::payment($price_obj);
					break;
				case 'stripe':
					$price_obj['source'] = $source;
					$res_stripe = StripeModel::payment($price_obj);
					if($res_stripe){
						$res_stripe = json_decode($res_stripe, true);
						if(isset($res_stripe['object']) && $res_stripe['object'] == 'charge' && $res_stripe['paid'] && $res_stripe['status'] == 'succeeded'){
							$charge_id = $res_stripe['id'];
						}else{
							$res_stripe = false;
							$res = false;
						}
					}
					break;
				case 'alipay':
					$res = AlipayModel::payment();
					break;
			}
		}else{
			
		}
		if(! $res){
			$ret['msg'] = 'Order Failed';
			return json($ret);
		}
		$ret['code'] = 1;
		$ret['data'] = ['redirect' => $res['redirect_url']];
		return json($ret);
    }

	private function _removeCart($session_id){
		return Db::name('cart')->where(['session_id' => $session_id])->delete();
	}
}
