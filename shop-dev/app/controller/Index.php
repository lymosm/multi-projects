<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\User;
use think\response\Json;
use think\facade\Db;
 
class Index extends BaseController
{
    public function __construct()
    {
        die('333');
        
    }
    public function index()
    {
        print_r(User::getList()->toArray());
        return View::fetch('index');
    }

    public function hello($name = 'hello')
    {
        return 'hello,' . $name;
    }
}
