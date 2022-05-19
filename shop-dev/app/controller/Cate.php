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
use app\model\ProductModel;

class Cate extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function index($id){
		if(! trim($id)){
			return View::fetch('404');
		}
		$cate = CateModel::getCateInfo($id);
		if(! $cate){
			return View::fetch('404');
		}
		$page = 1;
		$limit = 2;
		$product_list = ProductModel::getProductListByCate(['c.cate_id' => $cate['id']], $page, $limit);
		$list = array_chunk($product_list, 4);

		View::assign('title', $cate['cate_name']);
		View::assign('cate', $cate);
		View::assign('list', $list);
		return View::fetch('cate');
	}
}
