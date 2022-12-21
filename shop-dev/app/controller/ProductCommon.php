<?php
namespace app\controller;

use app\BackController;
use think\facade\View;
use think\facade\Request;
use think\facade\Db;
use app\model\ProductModel;
use app\model\CateModel;
// use think\App;

class ProductCommon extends BackController
{
	public static function productImgSave(int $id){
        
		$img_ids = trim(Request::param('img_ids'));
		$main_img_id = intval(Request::param('main_img_id'));
		
		$old_main_img_id = self::getMainImgId($id);
		$imgs = [];
		if($main_img_id && ! $old_main_img_id){
			$imgs[] = [
				'product_id' => $id,
				'attachment_id' => $main_img_id,
				'is_main' => 1
			];
		}else if($main_img_id && $old_main_img_id && $main_img_id != $old_main_img_id ){
			$status_update = Db::name('product_img')
				->where(['id' => $old_main_img_id])
				->update([
					'attachment_id' => $main_img_id
				]);
			if($status_update === false){
				return false;
			}
		}
		
		if($img_ids){
			$status3 = Db::name('product_img')->where(['product_id' => $id, 'is_main' => 0])->delete();

			if($status3 === false){			
				return false;
			}

			$img_arr = explode(',', $img_ids);
			foreach($img_arr as $a_id){
				$a_id = intval($a_id);
				if(! $a_id){
					continue;
				}
				$imgs[] = [
					'product_id' => $id,
					'attachment_id' => $a_id,
					'is_main' => 0
				];
			}
		}
		$status4 = Db::name('product_img')->insertAll($imgs);
		if($status4 === false){			
			return false;
		}

		return true;
    }

	public static function getMainImgId(int $id){
		$data = Db::name('product_img')
			->field('id')
			->where(['product_id' => $id, 'is_main' => 1])
			->find();
		if($data && isset($data['id'])){
			return $data['id'];
		}
		return ;
	}

	public static function getProductImgs($id){
		$data = Db::name('product_img')
			->alias('a')
			->join('attachment b', 'a.attachment_id = b.id', 'left')
			->field('a.product_id, a.attachment_id, b.uri')
			->where(['a.product_id' => $id, 'a.is_main' => 0])
			->select()
			->toArray();
		return $data;
	}

}
