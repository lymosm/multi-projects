<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use think\response\Json;

class Home extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function uid(){
		echo uniqid();
		die;
	}
    
	public function video($id){
		if(! $id){
			echo 'error';
			exit;
		}
		$id = '6247c151ce020'; // debug
		// $data = Db::name('video_list')->field('video_uri')->where(['qrcode_uri' => $id])->find();
		$data = Db::name('video_list')->field('video_uri')->where(['qrcode_uri' => $id])->find();
		$uri = $data['video_uri'];
	    
		
		$file_url = $this->url($uri);
		View::assign('file_url', $file_url);
		View::assign('uri', $this->url('/Home/flow/id/' . $id));
	    return View::fetch('video2');
	}
   
	public function flow($id){
		$data = Db::name('video_list')->field('video_uri')->where(['qrcode_uri' => $id])->find();
		$uri = $data['video_uri'];
	    
		header("Content-type:text/html;charset=utf-8");
		$file_name = BASE_PATH . '/public' . $uri;

		$file_path = $file_name;
		if (! file_exists($file_path)) {
			echo 'Not Found';
			exit;
		}
		$fp = fopen($file_path, 'r');
		$file_size = filesize($file_path);

		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length:" . $file_size);
		Header("Content-Length:" . $file_size);
		Header("Content-Disposition: attachment; filename=" . $file_name);

		$buffer = 1024 * 20;
		$file_count = 0;
		while (!feof($fp) && $file_count < $file_size) {
			$file_con = fread($fp, $buffer);
			$file_count += $buffer;
			echo $file_con;
		}
		fclose($fp);
		exit;
	}
}