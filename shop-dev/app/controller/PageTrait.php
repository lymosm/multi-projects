<?php
namespace app\controller;

use think\facade\Request;
use think\facade\Db;
use think\facade\View;
use app\model\PageModel;
use app\controller\Error;

Trait PageTrait 
{

	public function page(string $uri = ''){
		if(! $uri){
			return Error::e404();
		}
		$data = PageModel::getPageByUri($uri);
		if(! $data){
			return Error::e404();
		}

		View::assign('title', $data['title']);
		View::assign('data', $data);
		return View::fetch('home/template/page');
	}

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
			$where .= 'a.title like "%' . $keyword . '%" ';
		}
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$list = PageModel::getList($where, ($page - 1) * $limit, $limit);
		$count = PageModel::getCount($where);
	
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
			'title' => '',
			'uri' => '',
			'id' => '',
			'content' => '',
		];
		$url_list = $this->url('/Admin/pageList');
		$url_update = $this->url('/Admin/actionPageEdit');

		View::assign('uri', 'pageList');
		View::assign('url', 'actionPageEdit');


		if(! $id){
			View::assign('title', 'Page Add');
		}else{
			View::assign('title', 'Page Edit');
			$data = PageModel::getPageAllById($id);
			error_log(print_r(htmlentities($data['content']), true) . "\r\n", 3, '/www/debug.log');

			View::assign('url', $url_update);
		}
		View::assign('url_list', $url_list);
		View::assign('data', $data);
        return View::fetch('pageEdit');
    }
	
	
	public function actionPageEdit(){

        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];

		$title = Request::param('title');
		$uri = Request::param('uri');
		$content = Request::param('content');
		$id = intval(Request::param('id'));
		if(! $title || ! $uri){
			$ret['msg'] = 'param error';
			return json($ret);
		}
		
		$date = date('Y-m-d H:i:s');
		$data = [
			'title' => $title,
			'uri' => $uri,
			'content' => $content
		];
		Db::startTrans();
		if($id){
			$data['updated_by'] = $this->userid;
			$data['updated_date'] = $date;
			$status = Db::name('page')->where(['id' => $id])->update($data);
		}else{
			$data['added_by'] = $this->userid;
			$data['added_date'] = $date;
			$status = Db::name('page')->insert($data);
		}
		
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
