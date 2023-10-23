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
use app\model\ProductModel;

class Cart extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function index(){
		$cart = CartModel::getCartData($this->session_id);
		View::assign('title', 'Cart');
		if(! $cart){
			return View::fetch('cart_empty');
		}
		$cart_content = json_decode($cart['cart_content'], true);
		if(isset($cart_content['product_list']) && ! $cart_content['product_list']){
			return View::fetch('cart_empty');
		}
		
		View::assign('product_list', $cart_content['product_list']);
		View::assign('price_obj', $cart_content['price_obj']);
		return View::fetch('cart');
	}

	public function addToCart(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		
		$id = intval(Request::param('id'));
        $qty = intval(Request::param('qty'));
		if(! $id || ! $qty){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$product = ProductModel::getProductById($id);
		if(! $product){
			$ret['msg'] = 'product error';
			return json($ret);
		}
		$item_price = $product['price'] * $qty;
		$product_item = [
			'item_hash' => $this->get_hash(),
			'product_id' => $product['id'],
			'uri' => $product['uri'],
			'product_name' => $product['name'],
			'qty' => $qty,
			'price' => $product['price'],
			'item_price' => $item_price
		];

		$cart = CartModel::getCartData($this->session_id);
		$is_update = false;
		if(! $cart){
			$cart = [
				'product_list' => [
					$product_item
					],
				'price_obj' => [
					'total_price' => $item_price
				]
				];
		}else{
			$cart = $cart['cart_content'];
			$is_update = true;
			$cart = json_decode($cart, true);
			$cart['product_list'][] = $product_item;
			$cart['price_obj']['total_price'] += $item_price;
		}
		$cart['price_obj']['need_payment'] = true;
		$cart['price_obj']['payment_type'] = 'paypal';
		if($cart['price_obj']['total_price'] == 0){
			$cart['price_obj']['need_payment'] = false;
		}
		$res = CartModel::saveCartData($this->session_id, $cart, $is_update);
		if($res === false){
			$ret['msg'] = 'save cart error';
			return json($ret);
		}
		$ret['code'] = 1;

		return json($ret);
	}

	public function get_hash(){
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()+-';
		$random = $chars[mt_rand(0,73)].$chars[mt_rand(0,73)].$chars[mt_rand(0,73)].$chars[mt_rand(0,73)].$chars[mt_rand(0,73)];//Random 5 times
		$content = uniqid() . $random;  
		return sha1($content); 
	}

	public function check(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];

		$cart = CartModel::getCartData($this->session_id);

		if($cart === false){
			$ret['msg'] = 'cart error';
			return json($ret);
		}
		if(isset($cart['cart_content'])){
			$cart = $cart['cart_content'];
			$cart = json_decode($cart, true);
			// error_log(print_r($cart, true) . "\r\n", 3, '/www/debug.log');

			$count = 0;
			if($cart['product_list']){
				foreach($cart['product_list'] as $rs){
					$count += intval($rs['qty']);
				}
			}
			$ret['data'] = [
				'count' => $count,
				'cart' => $cart
			];
		}
		$ret['code'] = 1;

		return json($ret);
	}

	public function delete(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];

		$id = trim(Request::param('id'));

		if(! $id){
			$ret['msg'] = 'params error';
			return json($ret);
		}
		$cart = CartModel::getCartData($this->session_id);

		if($cart === false){
			$ret['msg'] = 'cart error';
			return json($ret);
		}
		if(isset($cart['cart_content'])){
			$cart = $cart['cart_content'];
			$cart = json_decode($cart, true);

			$item_price = 0;
			if($cart['product_list']){
				$product_item = $cart['product_list'];

				foreach($product_item as $key => $rs){
					if($rs['item_hash'] == $id){
						unset($product_item[$key]);
						$item_price = $rs['item_price'];
						break;
					}
				}
			}
			
			$cart['product_list'] = $product_item;
			$cart['price_obj']['total_price'] -= $item_price;
			$res = CartModel::saveCartData($this->session_id, $cart, true);
			if($res === false){
				$ret['msg'] = 'save cart error';
				return json($ret);
			}
			
		}
		$ret['code'] = 1;
		$ret['data'] = $cart;

		return json($ret);
	}
}
