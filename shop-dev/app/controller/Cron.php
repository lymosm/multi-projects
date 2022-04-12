<?php
/**
 * 存放自动任务
 * 执行：php index.php cron/settleMain(方法名)
 * 
 */
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\User;
use think\response\Json;
use think\facade\Db;
use think\facade\Request;
use think\facade\Config;

define('RUNTIME_PATH', BASE_PATH . '/runtime/');

class Cron extends BaseController{
	
	public $del_status = false;
	public $dir_flag = '';
	public $date_filename = '';
	public $date = '';
	public $is_ctrl = false;
	
	public function __construct(\think\App $app, $is_ctrl = false)
	{
		if(php_sapi_name() !== 'cli' && ! $is_ctrl){
			die();
		}
	    parent::__construct($app, false);
	}

    /**
     * 记录日志
     * @param $msg 
     */
    public function log($msg){

        $dir = RUNTIME_PATH . 'cron-logs';
        if(! file_exists($dir)){
            mkdir($dir, 0777);
        }
        $dir .= '/' . $this->dir_flag;
        if(! file_exists($dir)){
            mkdir($dir, 0777);
        }
        // 删除旧文件
        if(! $this->del_status){
            $this->delfile($dir);
        }

        $msg = date('Y-m-d H:i:s') . '======' . $msg . "<br />\r\n";
        $file = $dir . '/' . $this->date_filename . '.log';
		if(! $this->is_ctrl){
			echo $msg;
		}
        
        file_put_contents($file, $msg, LOCK_EX | FILE_APPEND);
    }

    /**
     * 删除文件
     */
    public function delfile($dir, $n = 7){
        $this->del_status = true;
        if(! is_dir($dir)){
            return ;
        }
        $dh = opendir($dir);
        if(! $dh){
            return ;
        }
        while(false !== ($file = readdir($dh))){
            if($file != '.' && $file != '..'){
                $fullpath = $dir . '/' . $file;
                if(! is_dir($fullpath)){
                    $info = pathinfo($fullpath);
                    if(! isset($info['extension']) || $info['extension'] != 'log'){
                        continue;
                    }
                    $filedate = date('Y-m-d', filemtime($fullpath));
                    $d1 = strtotime(date('Y-m-d'));
                    $d2 = strtotime($filedate);
                    $diff_days = round(($d1 - $d2) / 3600 / 24);
                    if($diff_days > $n){
                        unlink($fullpath);
                    }
                }
            }
        }
        closedir($dh);
    }
}
