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
	
	public function index(){
		return $this->videoList();
	}

    public function videoList(){
		$list = Db::name('video_list')
			->field('id, name, added_date')
            ->order('id', 'desc')
			->select();
		
		View::assign('list', $list);
		$url = $this->url('/Admin/videoEdit');
		$url_pass = $this->url('/Admin/pass');
		$logout_url = $this->url('/AdminLogin/logout');
		$home = $this->url('/Home');
		$base_url = $this->url('/');
		View::assign('url', $url);
		View::assign('url_pass', $url_pass);
		View::assign('logout_url', $logout_url);
		View::assign('base_url', $base_url);
		View::assign('home', $home);
		return View::fetch('videoList');
    }
	
	public function ajaxVideoList(){
		
		$where = '';
		$keyword = addslashes(trim(Request::param('keyword')));
		if($keyword){
			$where .= 'a.name like "%' . $keyword . '%" or b.qrcode_uri like "%' . $keyword . '%"';
		}
		$page = intval(Request::param('page'));
		if(! $page){
			$page = 1;
		}
		$limit = intval(Request::param('limit'));
		if(! $limit){
			$limit = 20;
		}
		
		$list = Db::name('video_list')
			->field('*')
		    ->where($where)
		    ->order('id', 'desc')
			->limit(($page - 1) * $limit, $limit)
			->select();
			
		$count = Db::name('video_list')
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

    public function pass(){
		$url = $this->url('/Admin/actionPass');
		View::assign('url', $url);
		
        return View::fetch('pass');
    }

    public function actionPass(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
        $id = trim(Request::param('pass'));
        $name = trim(Request::param('pass2'));
		if(!$id || ! $name){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		if($id != $name){
			$ret['msg'] = '两次密码不一致';
			return json($ret);
		}

		$date = date('Y-m-d H:i:s');
		$pass = md5(md5($name . 'video'));
		$data = [
			'pwd' => $pass,
			'updated_date' => $date
        ];
        $where = [
            'id' => $this->userid
        ];
		$status = Db::name('user')->where($where)->update($data);
		if(! $status){
			$ret['msg'] = '更新失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
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
		// sleep(10);
		$ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
		$name = trim(Request::param('name'));
		$uid = trim(Request::param('uid'));
		if(! $name || ! $uid){
			$ret['msg'] = '参数错误';
			return json($ret);
		}
		$ret['data'] = $uid;
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
			'origin_video_uri' => $res['origin_uri'],
			'video_uri' => $res['video_uri'],
			'qrcode_uri' => $res['qrcode_uri'],
			'qrcode_text' => $res['qrcode_text'],
			'qrcode_img_uri' => $res['qrcode_img_uri'],
			'detail_uri' => $res['detail_uri']
		];
		$status = Db::name('video_list')->insert($data);
		if(! $status){
			$ret['msg'] = '添加失败 code 10002';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
	}
	
	private function _drawtextTest(){
		 $command = '/usr/local/ffmpeg/bin/ffmpeg -i "/Users/lymos/Downloads/27.MOV" -vf "drawtext=fontfile=/Users/lymos/Downloads/font.TTF:text=' . "'TangJiuling9009'" . ':y=h-line_h-10:x=:fontsize=60:fontcolor=yellow:shadowy=2" -b:v 500k -c:v libx264 -s 640x320 /Users/lymos/Downloads/28.mp4';
		// 从左往右 x=(mod(2*n\,w+tw)-tw)
		// 从右往左 x=w-(t-4.5)*w/5.5(只滚一次) x=w-w/10*mod(t\,13)(多次滚)
		$ret = exec($command, $output, $status);
		die;
	}
	
	private function _dealUpload(){
		$origin_uri = $this->_moveOriginFile();
		// $origin_uri = BASE_PATH . '/public/storage/v-origin/20220403/27.MOV'; // debug
		$uname = uniqid();
		// $video_uri = $this->_ffpmegVideo(BASE_PATH . '/public' . $origin_uri, $uname);
		$bin = '/usr/local/ffmpeg/bin/ffmpeg';
		$text = trim(Request::param('text'));
		$fontsize = intval(Request::param('fontsize'));
		if(! $fontsize){
			$fontsize = 20;
		}
		$mins = intval(Request::param('mins'));
		if(! $mins){
			$mins = 30;
		}
		$ma = intval(Request::param('ma'));
		if(! $ma){
			$ma = 1000;
		}
		$color = trim(Request::param('color'));
		if(! $color){
			$color = 'Yellow';
		}
		$filepath = BASE_PATH . '/public/storage/v-encode/' . date('Ymd');
		if(! file_exists($filepath)){
			mkdir($filepath, 0777, true);
		}
		$file =  $filepath . '/' . $uname . '.mp4';
		
		$video_uri = $this->_drawtext($bin, BASE_PATH . '/public' . $origin_uri, $text, $fontsize, $color, $file, $mins, $ma);
		
		if(! $video_uri){
			return false;
		}
		$qrcode_data = $this->_genQrcode($uname);
		$detail_uri = md5($uname);
		
		return array_merge($qrcode_data, [
			'detail_uri' => $detail_uri,
			'video_uri' => $video_uri,
			'origin_uri' => $origin_uri
		]); 
	}
	
	private function _ffpmegVideo($origin_uri, $uname){
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
			->watermark($watermark, 
				array(
			        'position' => 'absolute',
			        'x' => 0,
			        'y' => 200,
			    )
			
			   /*
				array(
				    'position' => 'relative',
				    'top' => 0,
				    'right' => '100',
				)
				*/
			)
		    ->synchronize();
			// $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))->save('frame.jpg');
			$filepath = BASE_PATH . '/public/storage/v-encode/' . date('Ymd');
			if(! file_exists($filepath)){
				mkdir($filepath, 0777, true);
			}
			$file =  $filepath . '/' . $uname . '.mp4';
		
			$ret = $video->save(new X264('libfdk_aac'), $file);
		// }catch(\Exception $e){
			// echo $e->getMessage(); die;
		// }

		return str_replace(BASE_PATH . '/public', '', $file);
		/*
./configure --prefix=/usr/local/ffmpeg  --enable-gpl  --enable-nonfree  --enable-libfdk-aac  --enable-libx264  --enable-libx265 --enable-filter=delogo --enable-debug --disable-optimizations --enable-libspeex --enable-videotoolbox --enable-shared --enable-pthreads --enable-libfreetype --enable-version3 --enable-hardcoded-tables --cc=clang --host-cflags= --host-ldflags=
*/

/*


/usr/local/ffmpeg/bin/ffmpeg -i "/Users/lymos/Downloads/27.MOV" -vf "drawtext=text='TangJiuling9009':y=h-line_h-10:x=(mod(2*n\,w+tw)-tw):fontsize=24:fontcolor=yellow:shadowy=2" -b:v 3000k /Users/lymos/Downloads/28.mov
*/
	}

	public function actionVideoDelete(){
        $ret = [
			'code' => 0,
			'data' => '',
			'msg' => ''
		];
        $id = intval(Request::param('id'));
		if(!$id){
			$ret['msg'] = '参数错误';
			return json($ret);
		}

        $where = [
            'id' => $id
        ];
		$status = Db::name('video_list')->where($where)->delete();
		if(! $status){
			$ret['msg'] = '删除失败';
			return json($ret);
		}
		$ret['code'] = 1;
		return json($ret);
    }
	
	private function _drawtext($bin, $origin, $text, $fontsize, $color, $out, $mins, $ma){
		// $command = '/usr/local/ffmpeg/bin/ffmpeg -i "/Users/lymos/Downloads/27.MOV" -vf "drawtext=fontfile=/Users/lymos/Downloads/font.TTF:text=' . "'TangJiuling9009'" . ':y=h-line_h-10:x=(mod(2*n\,w+tw)-tw):fontsize=24:fontcolor=yellow:shadowy=2" -b:v 500k -c:v libx264 -s 640x320 /Users/lymos/Downloads/28.mp4';
		// 从左往右 x=(mod(2*n\,w+tw)-tw)
		// 从右往左 x=w-(t-4.5)*w/5.5(只滚一次) x=w-w/10*mod(t\,13)(多次滚)
		// x=w-w/' . $mins . '*mod(t\,' . $mins . ')
		// x=w-t*w/' . $mins . '*mod(t\,' . $mins . ')
		// x=w-t*w/10
		$command = $bin . ' -i "' . $origin . '" -vf "drawtext=fontfile=' . BASE_PATH . '/public/static/fonts/font.TTF:text=' . "'" . $text . "'" . ':y=h-line_h-20:x=w-(w+tw)/' . $mins . '*mod(t\,' . $mins . '):fontsize=' . $fontsize . ':fontcolor=' . $color . ':shadowy=2" -b:v ' . $ma . 'k -r 24 -c:v libx264 ' . $out . ' 2>&1';
		$ret = exec($command, $output, $status);

		// $ret = system($command, $status);
		if($status){
			return false;
		}
		// echo '<pre>'; print_r($ret); die;
		return str_replace(BASE_PATH . '/public', '', $out);
	}
	
	private function _addGif(){
		$command = "ffmpeg -y -i test1.mp4 -ignore_loop 0 -i girl.gif  -filter_complex '[0:0]scale=iw:ih[a];[1:0]scale=iw/4:-1[wm];[a][wm]overlay=x=0:0:shortest=1' test_out8.mp4";
		
	}
	
	private function _genQrcode($uname){
		$filepath = BASE_PATH . '/public/storage/qrcode/' . date('Ymd');
		if(! file_exists($filepath)){
			mkdir($filepath, 0777, true);
		}
		$file =  $filepath . '/' . $uname . '.png';
		
		$info = $this->url('/Home/video/id/' . $uname);
		// $label = 'This is the label';
		$result = Builder::create()
		    ->writer(new PngWriter())
		    ->writerOptions([])
		    ->data($info)
		    ->encoding(new Encoding('UTF-8'))
		    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
		    ->size(300)
		    ->margin(10)
		    ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
		 /*  ->logoPath(__DIR__.'/assets/symfony.png')
		    ->labelText($label)
		    ->labelFont(new NotoSans(20))
		    ->labelAlignment(new LabelAlignmentCenter())
			*/
		    ->build();
		$result->saveToFile($file);
		return [
			'qrcode_img_uri' => str_replace(BASE_PATH . '/public', '', $file),
			'qrcode_uri' => $uname,
			'qrcode_text' => $info
		];
	}
	
	private function _moveOriginFile(){
		$file = request()->file('file');	
		$filename = $file->getOriginalName();
		$savename = \think\facade\Filesystem::disk('public')->putFileAs('v-origin/' . date('Ymd'), $file, $filename);
		return '/storage/' . $savename;
	}
}
