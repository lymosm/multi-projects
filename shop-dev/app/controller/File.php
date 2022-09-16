<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Request;
use think\facade\Db;
use think\response\Json;
use think\facade\Route;
// use think\Request;


class File extends BaseController
{
	
	public function __construct(\think\App $app){
		parent::__construct($app, false);
	}

	public function upload(){
		$ret = [
			'code' => 0,
			'data' => [
				'id' => 0,
				'url' => ''
			],
			'msg' => ''
		];
		
		$file = request()->file('file');

		$type = 'doc';
		$dir = 'product';
		$file_name = \think\facade\Filesystem::disk('public')->putFile($dir, $file);
		// $file_name = \think\facade\Filesystem::putFile($dir, $file);

		$ret['data'] = $this->_saveAttachData($file_name, $file_name, $type);
		if($ret['data']){
			$ret['code'] = 1;
		}
		
		return json($ret);
	}

	private function _saveAttachData($file_name, $uri, $type){
		$data = [
			'name' => $file_name,
			'uri' => $uri,
			'type' => $type,
			'added_by' => $this->userid,
			'added_date' => $this->date
		];
		$id = Db::name('attachment')->insertGetId($data);
		if(! $id){
			return false;
		}

		return [
			'id' => $id,
			'url' => '/storage/' . $uri
		];
	}
}
