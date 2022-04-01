<?php
namespace app\controller;

use app\BackController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
// use think\App;

class Admin extends BackController
{
	
	public $order_status_list = [
		0 => '待付款',
		1 => '已付款',
		2 => '付款失败',
		3 => '已退款',
		4 => '已取消'
	];
	
	public $cashout_status_list = [
		0 => '待支付',
		1 => '已支付',
		// 2 => '废弃'
	];
   

    public function videoList(){
		$list = Db::name('video_list')
			->field('id, name, added_date')
            ->order('id', 'desc')
			->select();
		
		View::assign('list', $list);
		$url = $this->url('/Admin/videoEdit');
		View::assign('url', $url);
		return View::fetch('videoList');
    }

    public function cashoutList(){
		View::assign('cashout_status_list', $this->cashout_status_list);
		return View::fetch('cashoutList');
    }
	
	public function ajaxCashoutList(){
		
		$where = [];
		
		$status = intval(Request::param('status'));
		if(isset($_GET['status']) && $_GET['status'] !== null && $_GET['status'] !== ''){
			$where['a.status'] = $status;
		}
		
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$count = Db::name('cashout_record')
			->alias('a')
			->join('user b', 'a.userid = b.id', 'left')
			->join('user_card c', 'a.userid = c.userid', 'left')
			->where($where)
			->field('count(*) as count')
			->select();
			
		$list = Db::name('cashout_record')
			->alias('a')
			->join('user b', 'a.userid = b.id', 'left')
			->join('user_card c', 'a.userid = c.userid', 'left')
			->where($where)
			->field('a.*, c.name, c.card, c.brand, c.wx_qrcode, c.ali_qrcode, b.mobile')
		    ->order('a.id', 'desc')
			->limit(($page - 1) * $limit, $limit)
			->select();
		
		$url = $this->url('/index.php?s=Admin/cashoutEdit');

		$ret = [
			'code' => 0,
			'count' => $count[0]['count'],
			'data' => $list,
			'msg' => ''
		];
		return json($ret);
	}

    public function cashoutEdit(){
		$url = $this->url('/Admin/actionCashoutEditAction');
		View::assign('url', $url);
		$id = intval(Request::param('id'));
		$where['a.id'] = $id;
		$data = Db::name('cashout_record')
			->alias('a')
			->join('user b', 'a.userid = b.id', 'left')
			->join('user_card c', 'a.userid = c.userid', 'left')
			->where($where)
			->field('a.id, a.amount, b.mobile, a.status')
			->find();
			
		View::assign('data', $data);
		View::assign('cashout_status_list', $this->cashout_status_list);
        return View::fetch('cashoutEdit');
    }

    public function actionCashoutEditAction(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
        $id = intval(Request::param('id'));
        $status = intval(Request::param('status'));
		if(! $id){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$date = date('Y-m-d H:i:s');
		$data = [
			'status' => $status,
			'updated_by' => $this->userid,
			'updated_date' => $date,
        ];
        $where = [
            'id' => $id
        ];
		$status = Db::name('cashout_record')->where($where)->update($data);
		if(! $status){
			$ret['msg'] = '更新失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
    }

	public function ajaxUserList(){
		
		$where = 'a.`status` = 1 ';
		$keyword = addslashes(trim(Request::param('keyword')));
		if($keyword){
			$where .= 'and a.mobile like "%' . $keyword . '%"';
		}
		
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$field = 'a.id, a.mobile, a.added_date, count(distinct b.invite_userid) as count1, count(distinct c.invite_userid) as count2,';
		$field .= 'count(distinct if(d.userid is null, null, d.userid)) as count1_pay, count(distinct if(e.userid is null, null, e.userid)) as count2_pay';
		$list = Db::name('user')->alias('a')
			->join('user_invite b', 'a.id = b.userid', 'left')
			->join('user_invite c', 'b.invite_userid = c.userid', 'left')
			->join('dcc_order d', 'd.userid = b.invite_userid and d.`status` = 1', 'left')
			->join('dcc_order e', 'e.userid = c.invite_userid and e.`status` = 1', 'left')
			->field($field)
		    ->where($where)
		    ->order('a.id', 'desc')
			->group('a.id')
			->limit(($page - 1) * $limit, $limit)
			->select()->toArray();
			
		$count = Db::name('user')->alias('a')
			->join('user_invite b', 'a.id = b.userid', 'left')
			->join('user_invite c', 'b.invite_userid = c.userid', 'left')
			->join('dcc_order d', 'd.userid = b.invite_userid and d.`status` = 1', 'left')
			->join('dcc_order e', 'e.userid = c.invite_userid and e.`status` = 1', 'left')
			->field('count(*) as count')
		    ->where($where)
			->group('a.id')
			->select();
		
		$userids = array_column($list, 'id');
        $cash = $this->_getUserInCash($userids);

        
		$ret = [
			'code' => 0,
			'count' => count($count),
			'data' => $list,
			'cash' => $cash,
			'msg' => ''
		];
		return json($ret);
	}

    public function orderList(){
		
		$where = '';
		$keyword = addslashes(trim(Request::param('keyword')));
		if($keyword){
			$where .= 'a.orderid like "%' . $keyword . '%" or b.mobile like "%' . $keyword . '%"';
		}
		
		$list = Db::name('order')->alias('a')
			->join('user b', 'a.userid = b.id', 'left')
			->field('a.id, a.orderid, a.total, a.status, a.added_date, b.mobile')
            ->where($where)
            ->order('id', 'desc')
			->select();
		
		$ret['code'] = 1;
		$ret['data'] = $list;
		View::assign('list', $list);
		View::assign('keyword', $keyword);
		View::assign('order_status_list', $this->order_status_list);
		return View::fetch('orderList');
    }
	
	public function ajaxOrderList(){
		
		$where = '';
		$keyword = addslashes(trim(Request::param('keyword')));
		if($keyword){
			$where .= 'a.orderid like "%' . $keyword . '%" or b.mobile like "%' . $keyword . '%"';
		}
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$list = Db::name('order')->alias('a')
			->join('user b', 'a.userid = b.id', 'left')
			->field('a.id, a.orderid, a.total, a.status, a.added_date, b.mobile')
		    ->where($where)
		    ->order('id', 'desc')
			->limit(($page - 1) * $limit, $limit)
			->select();
			
		$count = Db::name('order')->alias('a')
			->join('user b', 'a.userid = b.id', 'left')
			->field('count(*) as count')
		    ->where($where)
			->select();
	
		$ret = [
			'code' => 0,
			'count' => $count[0]['count'],
			'data' => $list,
			'msg' => ''
		];
		return json($ret);
	}

    public function taskEdit(){
		$id = intval(Request::param('id'));
		$data = [
			'name' => '',
			'id' => ''
		];
		$url = $this->url('/Admin/actionTaskAdd');
		$url_update = $this->url('/Admin/actionTaskEdit');
		if(! $id){
			View::assign('url', $url);
		}else{
			$data = Db::name('task')->field('id, name')->where(['id' => $id])->find();
			View::assign('url', $url_update);
		}
		
		View::assign('data', $data);
        return View::fetch('taskEdit');
    }

    public function actionTaskEdit(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
        $id = trim(Request::param('id'));
        $name = trim(Request::param('name'));
		if(!$id || ! $name){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$date = date('Y-m-d H:i:s');
		$data = [
			'name' => $name,
			'updated_by' => $this->userid,
			'updated_date' => $date
        ];
        $where = [
            'id' => $id
        ];
		$status = Db::name('task')->where($where)->update($data);
		if(! $status){
			$ret['msg'] = '更新失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
    }

    public function actionTaskAdd(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$name = trim(Request::param('name'));
		if(! $name){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$date = date('Y-m-d H:i:s');
		$data = [
			'name' => $name,
			'added_by' => $this->userid,
			'added_date' => $date,
			
		];
		$status = Db::name('task')->insert($data);
		if(! $status){
			$ret['msg'] = '添加失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
	}
}
