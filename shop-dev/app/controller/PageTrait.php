<?php
namespace app\controller;

use think\facade\Request;
use think\facade\Db;
use think\facade\View;

Trait PageTrait 
{

	public function pageList(){
		
		$url = $this->url('/Admin/pageEdit');
		
		View::assign('url', $url);
		View::assign('uri', 'pageList');
		View::assign('title', 'Page List');
		
		return View::fetch('pageList');
    }

	public function ajaxPageList(){
		
		$where = [];
		$keyword = addslashes(trim(Request::param('keyword')));
		if($keyword){
			$where .= 'a.order_num like "%' . $keyword . '%" ';
		}
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$list = UserModel::getUserList($where, ($page - 1) * $limit, $limit);
		$count = UserModel::getUserCount($where);
	
		$ret = [
			'code' => 0,
			'count' => $count,
			'data' => $list,
			'msg' => ''
		];
		return json($ret);
	}

	public function pageEdit(){
		$id = intval(Request::param('id'));
		$data = [
			'account' => '',
			'name' => '',
			'id' => '',
			'role_id' => '',
		];
		$url_list = $this->url('/Admin/userList');
		$url_update = $this->url('/Admin/actionUserEdit');
		$role_list = RoleModel::getListOptions();

		View::assign('uri', 'userList');
		View::assign('url', 'userList');


		if(! $id){
			View::assign('title', 'User Add');
		}else{
			View::assign('title', 'User Edit');
			$data = UserModel::getUserAllById($id);
			View::assign('url', $url_update);
		}
		View::assign('url_list', $url_list);
		View::assign('role_list', $role_list);
		View::assign('data', $data);
        return View::fetch('userEdit');
    }
	
	
	public function actionPageEdit(){

        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];

		$role_id = intval(Request::param('role'));
		$id = intval(Request::param('id'));
		if(! $role_id || ! $id){
			$ret['msg'] = 'param error';
			return json($ret);
		}
		
		$date = date('Y-m-d H:i:s');
		$data = [
			'role_id' => $role_id
		];
		Db::startTrans();
		$status = Db::name('user_role')->where(['user_id' => $id])->update($data);
		if($status === false){
			Db::rollback();
			$ret['msg'] = 'save failed code 10002';
			return json($ret);
		}

		

		$commit = Db::commit();
        if($commit === false){
            Db::rollback();
			$ret['msg'] = 'save failed code 10006';
            return json($ret);
        }

		$ret['code'] = 1;
		$ret['msg'] = 'save success';
		return json($ret);
    }

   
}
