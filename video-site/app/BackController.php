<?php
declare (strict_types = 1);

namespace app;

use think\App;
use think\exception\ValidateException;
use think\Validate;
use think\facade\View;

/**
 * 控制器基础类
 */
abstract class BackController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];
	
	public $userid;
	public $is_check_login = true;

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        if($this->is_check_login && ! $this->islogin()){
			$login_url = $this->url('/AdminLogin');
			header('Location: ' . $login_url);
            exit;
        }

        // 控制器初始化
        $this->initialize();
		
		$logout_url = $this->url('/AdminLogin/Logout');
		View::assign('logout_url', $logout_url);
		
    }

    public function isLogin(){
        // $userid = intval(cookie('userid'));
		$userid = intval(session('userid'));
		$this->userid = $userid;
        // $token = cookie('token');
		$token = session('token');
        if(! $userid || ! $token){
            return false;
        }
        if($token != md5('video' . $userid . '8923')){
            return false;
        }
        return true;
    }
	
	public function url($uri){
		$host = $_SERVER['HTTP_HOST'];
		$scheme = $_SERVER['REQUEST_SCHEME'];
		$url = $scheme . '://' . $host . $uri;
		return $url;
	}

    // 初始化
    protected function initialize()
    {}

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

	public function verify_token(){
		return true;
		return false;
	}
	
	public function curl($url, $method = 'GET', $data = [], $header = []){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		if(strtoupper($method) == 'POST'){
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		}

		$ret = curl_exec($ch);
		
		curl_close($ch);
		return $ret;
	}
	
}
