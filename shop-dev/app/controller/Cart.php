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
}
