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
		
		
		$cart = CartModel::getCartData();

		View::assign('title', 'Cart');
		View::assign('cart', $cart);
		return View::fetch('cart');
	}
}
