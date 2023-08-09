<?php
namespace app\controller;

use app\BackController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use think\Request as Requ;
use think\exception\ValidateException;

class HomeLogin extends BackController
{
	public function __construct(\think\App $app){
		$this->is_check_login = false;
		parent::__construct($app);
	}
    
    public function index()
    {
		$url = $this->url('/AdminLogin/login');
		View::assign('url', $url);
		$list_url = $this->url('/Admin/productList');
		View::assign('list_url', $list_url);
        return View::fetch('login');
    }

	public function captcha(){

	}

    public function login(Requ $request){
		
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
		
        $account = trim(Request::param('account'));
        $pwd = trim(Request::param('pwd'));
		$captcha = trim(Request::param('captcha'));
		if(! $account || ! $pwd || $captcha){
			$ret['msg'] = '参数错误';
			return json($ret);
		}

		if(! captcha_check($captcha)){
			$ret['msg'] = 'captcha error';
			// return json($ret);
		};


		$pwd = md5(md5($pwd . 'shop'));
		$where = [
			'account' => $account,
            'pwd' => $pwd
		];
		$data = Db::name('user')
			->field('id')
            ->where($where)->find();
        if($data){
            $ret['code'] = 1;
            $this->setLogin($data['id']);
        }else{
            $ret['msg'] = '账号或密码错误';
        }
		
		//$url = $this->url('/index.php?s=admin/taskList');
		//return redirect($url);
		
		return json($ret);
    }
	
	public function logout(){
		$this->setLogout();
		$ret = [
			'code' => 1,
			'data' => '',
			'msg' => ''
		];
		return json($ret);
	}
	
	public function setLogin($userid){
	    session('userid', $userid);
		// cookie('userid', $userid);
	    $token = md5('video' . $userid . '8923');
	    session('token', $token);
		// cookie('token', $token);
	    return true;
	}
	
	public function setLogout(){
		// cookie('userid', null);
		// cookie('token', null);
		session(null);
	}
}
