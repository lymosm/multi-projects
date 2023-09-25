<?php
declare(strict_types = 1);

namespace app\controller;

use think\facade\View;
use think\facade\Request;
use think\facade\Db;
use app\model\MenuModel;


trait MenuTrait{

    public function menu(){
        $url = $this->url('/Admin/productEdit');
		$menu_data = MenuModel::getMenuTree();
        View::assign('menu_list', $menu_data['menu_list']);
        View::assign('menu_items', $menu_data['menu_items']);

		View::assign('url', $url);
		View::assign('uri', 'menu');
		View::assign('title', 'Menu');
		return View::fetch('menuManager');
    }

	public function addMenu(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$name = trim(Request::param('name'));
		$url = trim(Request::param('url'));
		
		if(! $name || ! $url){
			$ret['msg'] = 'param error';
			return json($ret);
		}
		
		$date = date('Y-m-d H:i:s');
		$data = [
			'name' => $name,
			'added_by' => $this->userid,
			'added_date' => $date,
			'url' => $url,
		];

		$id = Db::name('menu_item')->insertGetId($data);
		if($id === false){
			$ret['msg'] = 'save failed code 10002';
			return json($ret);
		}

		$ret['code'] = 1;
		$ret['data'] = $id;
		$ret['msg'] = 'save success';
		return json($ret);
	}

	/**
	 * [
	 * 	0 => [
	 * 		name => aaa,
	 * 		child => [
	 * 			0 => [
	 * 				name => aaaa,
	 * 				child => []
	 * 			]
	 * 		]
	 * ]
	 * ]
	 */
	public function saveMenu(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];

		$tree = $this->_genTree();

		$name = 'main-menu';
		$menu = json_encode($tree);
		$data = [
			'name' => $name,
			'menu' => $menu
		];
		$date = date('Y-m-d H:i:s');
		$old = Db::name('menu')->where(['name' => $name])->find();
		if($old){
			$data['updated_by'] = $this->userid;
			$data['updated_date'] = $date;
			$res = Db::name('menu')->where(['name' => $name])->update($data);
		}else{
			$data['added_by'] = $this->userid;
			$data['added_date'] = $date;
			$res = Db::name('menu')->insert($data);
		}

		if($res === false){
			$ret['msg'] = 'save failed code 10002';
			return json($ret);
		}

		$ret['code'] = 1;
		$ret['msg'] = 'save success';
		return json($ret);
	}

	private function _genTree(){
		$ids = $_POST['menu_id'];
		$parents = $_POST['menu_parent'];
		$tree = [];
		foreach($ids as $id){
			$parent = $parents[$id];
			if(! $parent){
				$tree[] = [
					'id' => $id
				];
			}
		}
		foreach($ids as $id2){
			$parent = $parents[$id2];
			if($parent){
				foreach($tree as $key => $rs){
					if($rs['id'] == $parent){
						$tree[$key]['_child'][] = $id2;
					}
				}
			}
		}
		return $tree;
	}
	
}