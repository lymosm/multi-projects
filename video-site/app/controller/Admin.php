<?php
namespace app\controller;

use app\BackController;
use think\facade\View;
use app\model\User; 
use think\facade\Request;
use think\facade\Db;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\ResizeFilter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
// use think\App;

class Admin extends BackController
{
	

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

    public function videoEdit(){
		$id = intval(Request::param('id'));
		$data = [
			'name' => '',
			'id' => ''
		];
		$url = $this->url('/Admin/actionVideoAdd');
		$url_update = $this->url('/Admin/actionVideoEdit');
		if(! $id){
			View::assign('url', $url);
		}else{
			$data = Db::name('video_list')->field('id, name')->where(['id' => $id])->find();
			View::assign('url', $url_update);
		}
		
		View::assign('data', $data);
        return View::fetch('videoEdit');
    }

    public function actionVideoEdit(){
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
		$status = Db::name('video_list')->where($where)->update($data);
		if(! $status){
			$ret['msg'] = '更新失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
    }

    public function actionVideoAdd(){
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		// echo '<pre>'; print_r($_POST); die;
		$name = trim(Request::param('name'));
		if(! $name){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$res = $this->_dealUpload();
		if($res === false){
			$ret['msg'] = '添加失败 code 10001';
			return json($ret);
		}
		$date = date('Y-m-d H:i:s');
		$data = [
			'name' => $name,
			'added_by' => $this->userid,
			'added_date' => $date,
			
		];
		$status = Db::name('video_list')->insert($data);
		if(! $status){
			$ret['msg'] = '添加失败 code 10002';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
	}
	
	private function _dealUpload(){
		// $origin_uri = $this->_moveOriginFile();
		// echo $origin_uri; die;
		$origin_uri = BASE_PATH . '/public/storage/v-origin/20220403/27.MOV'; // debug
		$video_uri = $this->_ffpmegVideo($origin_uri);
		echo $video_uri; die;
		$qrcode_data = $this->_genQrcode();
		$detail_uri = '';
		
		return [
			
		]; 
	}
	
	private function _ffpmegVideo($origin_uri){
		$config = [
			'ffmpeg.binaries' => '/usr/local/ffmpeg/bin/ffmpeg',
			'ffprobe.binaries' => '/usr/local/ffmpeg/bin/ffprobe'
		];
		$ffmpeg = FFMpeg::create($config);
		$video = $ffmpeg->open($origin_uri);
		$watermark = BASE_PATH . '/public/static/image/watermark.png';
		// try{
			$video->filters()
		    ->resize(new Dimension(320, 240), ResizeFilter::RESIZEMODE_INSET, true)
			->watermark($watermark, array(
			        'position' => 'relative',
			        'bottom' => 50,
			        'right' => 0,
			    ))
		    ->synchronize();
			// $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))->save('frame.jpg');
			$filepath = BASE_PATH . '/public/storage/v-encode/' . date('Ymd');
			if(! file_exists($filepath)){
				mkdir($filepath, 0777, true);
			}
			$file =  $filepath . '/' . uniqid() . '.mp4';
		
			$ret = $video->save(new X264('libfdk_aac'), $file);
		// }catch(\Exception $e){
			// echo $e->getMessage(); die;
		// }

		return str_replace(BASE_PATH, '', $file);
		/*
./configure --prefix=/usr/local/ffmpeg  --enable-gpl  --enable-nonfree  --enable-libfdk-aac  --enable-libx264  --enable-libx265 --enable-filter=delogo --enable-debug --disable-optimizations --enable-libspeex --enable-videotoolbox --enable-shared --enable-pthreads --enable-version3 --enable-hardcoded-tables --cc=clang --host-cflags= --host-ldflags=
*/
	}
	
	private function _genQrcode(){
		$info = 'Custom QR code contents';
		$label = 'This is the label';
		$file = '';
		$result = Builder::create()
		    ->writer(new PngWriter())
		    ->writerOptions([])
		    ->data($info)
		    ->encoding(new Encoding('UTF-8'))
		    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
		    ->size(300)
		    ->margin(10)
		    ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
		 //   ->logoPath(__DIR__.'/assets/symfony.png')
		    ->labelText($label)
		    ->labelFont(new NotoSans(20))
		    ->labelAlignment(new LabelAlignmentCenter())
		    ->build();
		$result->saveToFile($file);
	}
	
	private function _moveOriginFile(){
		$file = request()->file('file');	
		$filename = $file->getOriginalName();
		$savename = \think\facade\Filesystem::disk('public')->putFileAs('v-origin/' . date('Ymd'), $file, $filename);
		return '/storage/' . $savename;
	}
	
	public function upload($name='image',$size=1024*1024*10,$ext='jpg,png,gif,jpeg',$save_dir='./uploads',$rule='date',$module='admin',$use='admin', $is_return = false){
	        $data = input();
	        $name = isset($data['name']) ? $data['name'] : $name; //提交的文件name
	        $size = isset($data['size']) ? $data['size'] : $size; //限制上传的文件大小
	        $ext  = isset($data['ext'])  ? $data['ext']  : $ext;  //文件格式
	        $save_dir = isset($data['save_dir']) ? $data['save_dir'] : $save_dir; //保存路径
	        $rule = isset($data['rule']) ? $data['rule'] : $rule; //生成的文件命名方式，默认支持：date根据日期和微秒数生成，md5对文件使用md5_file散列生成,sha1对文件使用sha1_file散列生成
	        $module = isset($data['module']) ? $data['module'] : $module;
	        $use = isset($data['use']) ? $data['use'] : $use;
	        if($this->request->file('file')){
	            $file = $this->request->file('file');
	            $info = $file->validate(['size'=>$size,'ext'=>$ext])->rule($rule)->move($save_dir);
	            if($info){
	                $url = $info->getSaveName();
	                $arr['url'] = $save_dir.'/'.$url;
	                $admininfo = $this->admininfo;
	                $data = [];
	                $uparr['module']      = $module;
	                $uparr['title']       = $info->getInfo('name');
	                $uparr['filename']    = $info->getFilename();//文件名
	                $uparr['filepath']    = ltrim($arr['url'],'.');//文件路径
	                $uparr['fileext']     = $info->getExtension();//文件后缀
	                $uparr['filesize']    = $info->getSize();//文件大小
	                $uparr['create_time'] = time();//时间
	                $uparr['uploadip']    = $this->request->ip();//IP
	                $uparr['u_id']        = isset($admininfo['id']) ? $admininfo['id'] : 0;
	
	                $uparr['use']     = $this->request->param('use') ? $this->request->param('use') : $use;//用处
	                $uparr['u_title'] = $this->request->param('utitle') ? $this->request->param('utitle') : '未知';
	                $nimg = str_replace("\\","/",$arr['url']);
	                $imgas = explode('.',$nimg);
	                $image = \think\Image::open($nimg);
	                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
	                $image->thumb(160,160)->save('.'.$imgas[1].'_160x160.'.$imgas[2]);
	                $image2 = \think\Image::open($nimg);
	                $image2->thumb(320,320)->save('.'.$imgas[1].'_320x320.'.$imgas[2]);
	                $uparr['filepath']         = $nimg;
	                $uparr['filepath_240x160'] = $imgas[1].'_240x160.'.$imgas[2];
	                $uparr['filepath_480x320'] = $imgas[1].'_480x320.'.$imgas[2];
	                $arr['id']   = Db::name('attachment')->insertGetId($uparr);
	                $arr['url']  = ltrim($arr['url'],'.');
	
	                if($is_return){
	                    return $arr;
	                }
	
	                return json(['code'=>0,'msg'=>'上传成功','returnData'=>$arr]);
	            }else{
	                return json(['code'=>1,'msg'=>'上传失败','returnData'=>$file->getError()]);
	            }
	        }else{
	            return json(['code'=>2,'msg'=>'请选择上传的图片','returnData'=>'']);
	        }
	    }
}
