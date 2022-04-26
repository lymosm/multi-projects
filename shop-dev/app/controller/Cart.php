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
		
	}
}
