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
		
		$session_id = session_id();
		$session_id = ''; // debug
		$cart = CartModel::getCartData($session_id);

		View::assign('title', 'Cart');
		View::assign('cart', $cart);
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
			'product_name' => $product['name'],
			'qty' => $qty,
			'price' => $product['price'],
			'item_price' => $item_price
		];

		$session_id = session_id();
		$cart = CartModel::getCartData($session_id);
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
			$cart = json_decode($cart, true);
			$cart['product_list'][] = $product_item;
			$cart['price_obj']['total_price'] += $item_price;
		}
		

		return json($ret);
	}
}
