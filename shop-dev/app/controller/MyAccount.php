<?php
namespace app\controller;

use app\BaseController;
use app\model\OrderModel;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use think\response\Json;
use app\model\Widget;
use think\Request as Requ;

trait MyAccount{

    public function account($type = ''){
		if(! $this->userid){
			// redirect('/');
			header('Location: /');
			exit;
		}

		$url_account = url('/account/my');
		$url_order = url('/account/order');
		$url_order_view = url('/account/view-order/');
		if(! $type){
			$type = 'my';
		}

		if($type == 'order'){
			$where = [
				'c.user_id' => $this->userid
			];
			$order_list = OrderModel::getUserOrderList($where, 0, 10);
			View::assign('order_list', $order_list);
		}else if($type != 'my'){
			$order = OrderModel::getOrderByNum($type);

			$type = 'view-order';
		//	error_log(print_r($order, true) . "\r\n", 3, '/www/debug.log');

			View::assign('order', $order);
		}

		View::assign('url_account', $url_account);
		View::assign('url_order', $url_order);
		View::assign('url_order_view', $url_order_view);
		View::assign('title', 'account');
		View::assign('userid', $this->userid);
		View::assign('user', $this->user);
		View::assign('type', $type);
		return View::fetch('account');
	}

	public function logout(){
		$this->setLogout();
		$url = $this->url('/');
		ob_clean();
		header('Location: ' . $url);
		exit;
	}

	public function setLogout(){
		// cookie('userid', null);
		// cookie('token', null);
		error_log(print_r(session('userid'), true) . "\r\n", 3, '/www/debug.log');

		session(null);
		error_log(print_r(session('userid'), true) . "\r\n", 3, '/www/debug.log');
	}

	public function changeAccount(Requ $request){
		
		$this->is_check_login = false;
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		
		$check = $request->checkToken('__token__');
		if(false === $check) {
		//	throw new ValidateException('invalid token');
		}
		
		$account_id = intval(Request::param('account_id'));
        $old_password = trim(Request::param('old_password'));
        $new_password = trim(Request::param('new_password'));
		$confirm_password = trim(Request::param('confirm_password'));
		if(! $old_password || ! $new_password || ! $confirm_password){
			$ret['msg'] = '参数错误';
			return json($ret);
		}

		$pwd = md5(md5($old_password . 'shop'));
		$where = [
			'id' => $account_id,
            'pwd' => $pwd
		];
		$data = Db::name('user')
			->field('id')
            ->where($where)->find();

		if(! $data){
			$ret['msg'] = 'password error';
			return json($ret);
		}

		if($new_password !== $confirm_password){
			$ret['msg'] = 'two new password not the same';
			return json($ret);
		}

		$new_password_str = md5(md5($new_password . 'shop'));
		$update_data = [
			'pwd' => $new_password_str,
			'updated_by' => $this->userid,
			'updated_date' => date('Y-m-d H:i:s')
		];
		$res = Db::name('user')->where(
			[
				'id' => $account_id
			]
		)->update($update_data);

		
        if($res !== false){
            $ret['code'] = 1;
        }else{
            $ret['msg'] = 'save failed';
        }
		
		//$url = $this->url('/index.php?s=admin/taskList');
		//return redirect($url);
		
		return json($ret);
    }
}