<?php
namespace app\controller;

use app\BackController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\ResizeFilter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use app\model\ProductModel;
use app\model\CateModel;
// use think\App;

class Admin extends BackController
{
	
	public function index(){
		return $this->productList();
	}

    public function productList(){
		
		$url = $this->url('/Admin/productEdit');
		
		View::assign('url', $url);
		View::assign('uri', 'productList');
		View::assign('title', 'Product List');
		return View::fetch('productList');
    }
	
	public function ajaxProductList(){
		
		$where = [];
		$keyword = addslashes(trim(Request::param('keyword')));
		if($keyword){
			$where .= 'a.name like "%' . $keyword . '%" or b.qrcode_uri like "%' . $keyword . '%"';
		}
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$list = ProductModel::getProductList($where, ($page - 1) * $limit, $limit);
			
		$count = ProductModel::getProductCount($where);
	
		$ret = [
			'code' => 0,
			'count' => $count,
			'data' => $list,
			'msg' => ''
		];
		return json($ret);
	}

	public function cateList(){

		$url = $this->url('/Admin/cateEdit');
		View::assign('title', 'Category List');
		View::assign('url', $url);
		View::assign('uri', 'cateList');
		return View::fetch('cateList');
    }

	public function ajaxCateList(){
		
		$where = [];
		$keyword = addslashes(trim(Request::param('keyword')));
		if($keyword){
			$where .= 'a.name like "%' . $keyword . '%" or b.qrcode_uri like "%' . $keyword . '%"';
		}
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$list = CateModel::getCateList($where, ($page - 1) * $limit, $limit);
			
		$count = CateModel::getCateCount($where);
	
		$ret = [
			'code' => 0,
			'count' => $count,
			'data' => $list['child'],
			'msg' => ''
		];
		return json($ret);
	}

    public function cateEdit(){
		$id = intval(Request::param('id'));
		$data = [
			'cate_name' => '',
			'id' => '',
			'desc' => '',
			'uri' => ''
		];
		$url = $this->url('/Admin/actionCateAdd');
		$url_list = $this->url('/Admin/cateList');
		$url_update = $this->url('/Admin/actionCateEdit');
		$cate_list = CateModel::getCateList();
		View::assign('uri', 'cateList');
		View::assign('cate_list', $cate_list['child']);

		if(! $id){
			View::assign('title', 'Category Add');
			View::assign('url', $url);
		}else{
			View::assign('title', 'Category Edit');
			$data = Db::name('cate')->alias('a')
				->join('cate_rela b', 'a.id = b.cate_id', 'left')
				->field('a.id, a.cate_name, a.desc, a.uri, b.parent_id')->where(['a.id' => $id])->find();
			View::assign('url', $url_update);
		}
		View::assign('url_list', $url_list);
		View::assign('data', $data);
        return View::fetch('cateEdit');
    }

	public function productEdit(){
		$id = intval(Request::param('id'));
		$data = [
			'cate_id' => '',
			'name' => '',
			'id' => '',
			'price' => '',
			'short_desc' => '',
			'long_desc' => '',
			'uri' => ''
		];
		$url = $this->url('/Admin/actionProductAdd');
		$url_list = $this->url('/Admin/productList');
		$url_update = $this->url('/Admin/actionProductEdit');
		$cate_list = CateModel::getCateList();
		$img_data = [];

		View::assign('uri', 'productList');
		View::assign('img_data', $img_data);
		View::assign('cate_list', $cate_list['child']);

		if(! $id){
			View::assign('title', 'Product Add');
			View::assign('url', $url);
		}else{
			View::assign('title', 'Product Edit');
			$data = ProductModel::getProductAllById($id);
			View::assign('url', $url_update);
		}
		View::assign('url_list', $url_list);
		View::assign('data', $data);
        return View::fetch('productEdit');
    }

    public function pass(){
		$url = $this->url('/Admin/actionPass');
		View::assign('url', $url);
		
        return View::fetch('pass');
    }

    public function actionPass(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
        $id = trim(Request::param('pass'));
        $name = trim(Request::param('pass2'));
		if(!$id || ! $name){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		if($id != $name){
			$ret['msg'] = '两次密码不一致';
			return json($ret);
		}

		$date = date('Y-m-d H:i:s');
		$pass = md5(md5($name . 'video'));
		$data = [
			'pwd' => $pass,
			'updated_date' => $date
        ];
        $where = [
            'id' => $this->userid
        ];
		$status = Db::name('user')->where($where)->update($data);
		if(! $status){
			$ret['msg'] = '更新失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
    }


    public function actionCateEdit(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$name = trim(Request::param('name'));
		$url = trim(Request::param('uri'));
		$desc = trim(Request::param('desc'));
		$parent_id = intval(Request::param('parent_id'));
		$id = intval(Request::param('id'));
		if(! $name || ! $url || ! $id){
			$ret['msg'] = 'param error';
			return json($ret);
		}
		
		$date = date('Y-m-d H:i:s');
		$data = [
			'cate_name' => $name,
			'updated_by' => $this->userid,
			'updated_date' => $date,
			'cate_name' => $name,
			'uri' => $url,
			'img_uri' => '',
			'desc' => $desc
		];
		Db::startTrans();
		$status = Db::name('cate')->where(['id' => $id])->update($data);
		if($status === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10002';
			return json($ret);
		}

		$rela = [
			'parent_id' => $parent_id
		];
		$status2 = Db::name('cate_rela')->where(['cate_id' => $id])->update($rela);
		if($status2 === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10003';
			return json($ret);
		}

		$commit = Db::commit();
        if($commit === false){
            Db::rollback();
            return false;
        }

		$ret['code'] = 1;
		$ret['msg'] = 'save success';
		return json($ret);
    }

	public function actionProductAdd(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$name = trim(Request::param('name'));
		$url = trim(Request::param('uri'));
		$short_desc = trim(Request::param('short_desc'));
		$long_desc = trim(Request::param('long_desc'));
		$price = trim(Request::param('price'));
		$cate_id = intval(Request::param('cate_id'));
		if(! $name || ! $url){
			$ret['msg'] = 'param error';
			return json($ret);
		}
		
		$date = date('Y-m-d H:i:s');
		$data = [
			'name' => $name,
			'added_by' => $this->userid,
			'added_date' => $date,
			'uri' => $url
		];
		Db::startTrans();
		$id = Db::name('product')->insertGetId($data);
		if($id === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10002';
			return json($ret);
		}

		$rela = [
			'cate_id' => $cate_id,
			'product_id' => $id
		];
		$status2 = Db::name('product_cate_rela')->insert($rela);
		if($status2 === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10003';
			return json($ret);
		}

		$detail = [
			'product_id' => $id,
			'price' => $price,
			'short_desc' => $short_desc,
			'long_desc' => $long_desc
		];
		$status3 = Db::name('product_detail')->insert($detail);
		if($status3 === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10004';
			return json($ret);
		}

		$imgs = [
			'product_id' => $id,
			'name' => $name,
			'added_by' => $this->userid,
			'added_date' => $date,
			'uri' => '',
			'is_main' => 1
		];
		$status4 = Db::name('product_img')->insert($imgs);
		if($status4 === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10005';
			return json($ret);
		}

		$commit = Db::commit();
        if($commit === false){
            Db::rollback();
            return false;
        }

		$ret['code'] = 1;
		$ret['msg'] = 'save success';
		return json($ret);
    }

	public function actionProductEdit(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$name = trim(Request::param('name'));
		$url = trim(Request::param('uri'));
		$short_desc = trim(Request::param('short_desc'));
		$long_desc = trim(Request::param('long_desc'));
		$price = trim(Request::param('price'));
		$cate_id = intval(Request::param('cate_id'));
		$id = intval(Request::param('id'));
		if(! $name || ! $url || ! $id){
			$ret['msg'] = 'param error';
			return json($ret);
		}
		
		$date = date('Y-m-d H:i:s');
		$data = [
			'name' => $name,
			'updated_by' => $this->userid,
			'updated_date' => $date,
			'uri' => $url
		];
		Db::startTrans();
		$status = Db::name('product')->where(['id' => $id])->update($data);
		if($status === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10002';
			return json($ret);
		}

		$rela = [
			'cate_id' => $cate_id
		];
		$status2 = Db::name('product_cate_rela')->where(['product_id' => $id])->update($rela);
		if($status2 === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10003';
			return json($ret);
		}

		$detail = [
			'price' => $price,
			'short_desc' => $short_desc,
			'long_desc' => $long_desc
		];
		$status3 = Db::name('product_detail')->where(['product_id' => $id])->update($detail);
		if($status3 === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10004';
			return json($ret);
		}

		$commit = Db::commit();
        if($commit === false){
            Db::rollback();
            return false;
        }

		$ret['code'] = 1;
		$ret['msg'] = 'save success';
		return json($ret);
    }

    public function actionCateAdd(){
		
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$name = trim(Request::param('name'));
		$url = trim(Request::param('uri'));
		$desc = trim(Request::param('desc'));
		$parent_id = trim(Request::param('parent_id'));
		if(! $name || ! $url){
			$ret['msg'] = 'param error';
			return json($ret);
		}
		
		$date = date('Y-m-d H:i:s');
		$data = [
			'cate_name' => $name,
			'added_by' => $this->userid,
			'added_date' => $date,
			'cate_name' => $name,
			'uri' => $url,
			'img_uri' => '',
			'desc' => $desc
		];
		Db::startTrans();
		$status = Db::name('cate')->insertGetId($data);
		if($status === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10002';
			return json($ret);
		}

		$rela = [
			'cate_id' => $status,
			'parent_id' => $parent_id
		];
		$status2 = Db::name('cate_rela')->insert($rela);
		if($status2 === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10003';
			return json($ret);
		}

		$commit = Db::commit();
        if($commit === false){
            Db::rollback();
            return false;
        }

		$ret['code'] = 1;
		$ret['msg'] = 'save success';
		return json($ret);
	}
	
	
	private function _dealUpload(){
		$origin_uri = $this->_moveOriginFile();
		// $origin_uri = BASE_PATH . '/public/storage/v-origin/20220403/27.MOV'; // debug
		$uname = uniqid();
		// $video_uri = $this->_ffpmegVideo(BASE_PATH . '/public' . $origin_uri, $uname);
		$bin = '/usr/local/ffmpeg/bin/ffmpeg';
		$text = trim(Request::param('text'));
		$fontsize = intval(Request::param('fontsize'));
		if(! $fontsize){
			$fontsize = 20;
		}
		$mins = intval(Request::param('mins'));
		if(! $mins){
			$mins = 30;
		}
		$ma = intval(Request::param('ma'));
		if(! $ma){
			$ma = 1000;
		}
		$color = trim(Request::param('color'));
		if(! $color){
			$color = 'Yellow';
		}
		$filepath = BASE_PATH . '/public/storage/v-encode/' . date('Ymd');
		if(! file_exists($filepath)){
			mkdir($filepath, 0777, true);
		}
		$file =  $filepath . '/' . $uname . '.mp4';
		
		$video_uri = $this->_drawtext($bin, BASE_PATH . '/public' . $origin_uri, $text, $fontsize, $color, $file, $mins, $ma);
		
		if(! $video_uri){
			return false;
		}
		$qrcode_data = $this->_genQrcode($uname);
		$detail_uri = md5($uname);
		
		return array_merge($qrcode_data, [
			'detail_uri' => $detail_uri,
			'video_uri' => $video_uri,
			'origin_uri' => $origin_uri
		]); 
	}
	
	public function actionVideoDelete(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
        $id = intval(Request::param('id'));
		if(!$id){
			$ret['msg'] = '参数错误';
			return json($ret);
		}

        $where = [
            'id' => $id
        ];
		$status = Db::name('video_list')->where($where)->delete();
		if(! $status){
			$ret['msg'] = '删除失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
    }
	
	
	private function _genQrcode($uname){
		$filepath = BASE_PATH . '/public/storage/qrcode/' . date('Ymd');
		if(! file_exists($filepath)){
			mkdir($filepath, 0777, true);
		}
		$file =  $filepath . '/' . $uname . '.png';
		
		$info = $this->url('/Home/video/id/' . $uname);
		// $label = 'This is the label';
		$result = Builder::create()
		    ->writer(new PngWriter())
		    ->writerOptions([])
		    ->data($info)
		    ->encoding(new Encoding('UTF-8'))
		    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
		    ->size(300)
		    ->margin(10)
		    ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
		 /*  ->logoPath(__DIR__.'/assets/symfony.png')
		    ->labelText($label)
		    ->labelFont(new NotoSans(20))
		    ->labelAlignment(new LabelAlignmentCenter())
			*/
		    ->build();
		$result->saveToFile($file);
		return [
			'qrcode_img_uri' => str_replace(BASE_PATH . '/public', '', $file),
			'qrcode_uri' => $uname,
			'qrcode_text' => $info
		];
	}
	
	private function _moveOriginFile(){
		$file = request()->file('file');	
		$filename = $file->getOriginalName();
		$savename = \think\facade\Filesystem::disk('public')->putFileAs('v-origin/' . date('Ymd'), $file, $filename);
		return '/storage/' . $savename;
	}
}
