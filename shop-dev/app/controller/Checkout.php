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

class Checkout extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function index(){
		
		$session_id = '';
		$cart = CartModel::getCartData($session_id);

		View::assign('title', 'Cart');
		View::assign('cart', $cart);
		return View::fetch('checkout');
	}
}
