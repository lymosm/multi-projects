<?php
namespace app\controller;

use think\facade\Request;
use think\facade\Db;

Trait AdminSubTrait 
{
	
	
	public function actionUserEdit(){

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
