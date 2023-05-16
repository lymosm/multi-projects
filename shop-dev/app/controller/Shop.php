<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use think\response\Json;
use app\model\Widget;
use app\model\CateModel;
use Lymos\Stripe\stripe;
use app\model\ProductModel;

class Shop extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function index(){
		$page = 1; 
		$limit = 20;
		$where = [];
		$list = ProductModel::getProductList($where, ($page - 1) * $limit, $limit);
		View::assign('title', 'shop');
		View::assign('list', $list);
		return View::fetch('index');
	}
	
	
}
