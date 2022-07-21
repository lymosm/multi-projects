<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use think\response\Json;
use app\model\Widget;
use app\model\ProductModel;

class Product extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function index($id){
		if(! trim($id)){
			return View::fetch('no-product');
		}
		$product = ProductModel::getProductInfo($id);
		if(! $product){
			View::assign('title', 'Product Not Found');
			return View::fetch('no_product');
		}
		$product_img = ProductModel::getProductImg($id);
		$product_recommand = ProductModel::getProductRecommand($id);

		View::assign('title', $product['name']);
		View::assign('product', $product);
		View::assign('product_img', $product_img);
		View::assign('product_recommand', $product_recommand);
		return View::fetch('product');
	}
}
