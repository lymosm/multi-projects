<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\User;
use think\response\Json;
use think\facade\Db;
use think\facade\Request;
use think\facade\Config;

 
class Task extends BaseController
{
    
	/**
	 * 访问：http://doucc.com/index.php?s=index/get_product
	 */
	public function getMeTask(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		
		$userid = intval($this->decrypt(Request::param('userid')));
		if(! $userid ){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		
		$date = date('Y-m-d');
		$where = [
			'a.userid' => $userid,
			'a.date' => $date
		];
		$list = Db::name('user_task')
			->alias('a')
			->leftJoin('task b', 'a.taskid = b.id')
			->field('b.id, b.name, a.process, a.status')
			->where($where)
			->select();
		
		$ret['code'] = 1;
		$ret['data'] = $list;
		return json($ret);
	}

	public function getAllTask(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];

		$userid = intval($this->decrypt(Request::param('userid')));
		if(! $userid ){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$date = date('Y-m-d');
		$where = [
			['b.id', '=', null],
			['a.is_enabled', '=', 1]
		];
		$list = Db::name('task')
			->alias('a')
			->leftJoin('user_task b','b.taskid = a.id and b.userid = ' . $userid . ' and b.date ="' . $date . '"')
			->field('a.id, a.name')
			->where($where)
			->select();		
		
		$ret['code'] = 1;
		$ret['data'] = $list;
		return json($ret);
	}

	/**
	 * 领取任务
	 */
	public function takeTask(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$taskid = intval(Request::param('id'));
		$userid = intval($this->decrypt(Request::param('userid')));
		if(! $taskid){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$date = date('Y-m-d');

		$can = $this->_checkCanTake($userid, $taskid, $date);
		$info = '';
		switch($can){
			case 1:
				$info = '您今日已领取该任务';
				break;
			case 999:
				
				break;
			case 3:
				$info = '请先购买机器人';
				break;
			default:
				$info = '您今天最多只能领取' . $can . '个任务';
				break;
		}
		if($can != 999){
			$ret['msg'] = $info;
			return json($ret);
		}
		
		$data = [
			'taskid' => $taskid,
			'userid' => $userid,
			'date' => $date,
			'status' => 1,
			'process' => 100,
			'added_date' => date('Y-m-d H:i:s')
		];
		$status = Db::name('user_task')->insert($data);
		if(! $status){
			$ret['msg'] = '领取失败';
			return json($ret);
		}
		$obj = new Cron($this->app, true);
		$obj->is_ctrl = true;
		$obj->settleMain($userid);

		$ret['code'] = 1;

		return json($ret);
	}

	private function _checkCanTake($userid, $taskid, $date){
		$order = Db::name('order')
			->field('count(*) as count')
			->where(
				[
					'userid' => $userid,
					'status' => 1,
					'total' => Config::get('app.p_price')
				]
			)->find();
		if(! $order || ! $order['count']){
			return 3;
		}
		
		$old_data = Db::name('user_task')
			->field('id')
			->where([
				'taskid' => $taskid,
				'userid' => $userid,
				'date' => $date
			])->find();
		if($old_data){
			return 1;
		}
		
		// 一天最大领取2个
		$count_data = Db::name('user_task')
			->field('count(*) as count')
			->where([
				'userid' => $userid,
				'date' => $date
			])->find();
		
		if($count_data && $count_data['count'] >= 2 * $order['count']){
			return 2 * $order['count'];
		}
		return 999;
	}
}
