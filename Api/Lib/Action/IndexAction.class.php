<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	public $cookiePath = '';
	public $domain = '';
	// public $myPublic = '';
	public function __construct(){
		$this->cookiePath = 'E:\wamp\www\api\user.tmp';
		$this->myPublic = dirname(__APP__).'/Public';
		if(!isset($_GET['domain'])){
			$this->domain = 'test.bbl.com';
		}
		else{
			$this->domain = $_GET['domain'];
		}
		$this->assign('domain',$this->domain);
		

	}

    public function index(){
    	$history = M('history');
    	$where =array();
    	if(isset($_POST['keyword'])&&trim($_POST['keyword'])!=''){
    		$where['name'] = array('like','%'.$_POST['keyword'].'%');
    	}

		if($_SESSION['uid']){
			if(!isset($_GET['dis'])){
				$where['uid'] = $_SESSION['uid'];
			}
			else{
				$this->disall = $_GET['dis'];
			}
			
		}
		else{
			// $where['uid'] = 0;
		}
    	// dump($where);
    	// dump($this->disall);

    	$hisArr = $history->where($where)->order('createTime DESC')->limit(20)->select();
    	// dump($hisArr);
    	$this->hisArr = $hisArr;


    	$this->display();

    }

    public function api(){
    	if(!IS_POST){
    		die('必需发送post请求');
    	}
    	if($_POST['url']==''){
    		$this->error('请求地址不能为空');
    	}

		$sendVar = array();
		// $curlpost = '';
		if(isset($_POST['key'])&&is_array($_POST['key'])&&is_array($_POST['value'])){
			foreach ($_POST['key'] as $key => $v) {
				if($v=='')continue;
				// $curlpost .= $v.'='.urlencode($_POST['value'][$key]).'&';
				$val = trim(trim($_POST['value'][$key]),',');
				if(stripos($val,',')!==false){
					$valArr = explode(',', $val);
				}
				else{
					$valArr = $val;
				}
				$sendVar[$v] = $valArr;
				$saveVar[$v] = $val;
			}
		}
    	if($_FILES){
    		// dump($_FILES);
    		$root = dirname($_SERVER['SCRIPT_FILENAME']).'/';
    		$info = $this->upload();
    		// dump($info);
    		if(is_array($info)){
	    		if($_POST['filename']!=''){
	    			$sendVar[$_POST['filename']] = '@'.$root.$info[0]['savepath'].$info[0]['savename'];
	    		}
	    		else{
	    			$sendVar['Filedata'] = '@'.$root.$info[0]['savepath'].$info[0]['savename'];
	    		}
    		}

    		
    	}
		$url = $_POST['url'];

		$res = $this->requestUrl($url,$sendVar);

		$history = M('history');
		$data['url'] = $url;
		$data['param'] = json_encode($saveVar);
		if(!isset($_POST['name']) || $_POST['name']==''){
			$data['name'] = $_POST['url'];
		}
		else{
			$data['name'] = $_POST['name'];
		}
		// dump($data);
		if($_SESSION['uid']){
			$data['uid'] = $_SESSION['uid'];
		}
		$count = $history->where($data)->count();
		// dump($count);
		if(!$count){
			$data['createTime'] = $_SERVER['REQUEST_TIME'];
			$history->add($data);
		}

    	
    }
    public function getHistory(){
    	if(!is_numeric($_POST['hid'])){
    		$this->error('参数出错');
    	}
    	$history = M('history');
    	$where['hid'] = $_POST['hid'];
    	$oneHistory = $history->where($where)->find();
    	$this->oneHistory = $oneHistory;
    	$this->param = (array)json_decode($oneHistory['param']);
    	// dump($this->param);
    	$this->display();
    	// echo json_encode($oneHistory);
    }

    public function login(){
    	// dump(md5(substr(md5(123456),-8,10)));
    	if(IS_POST){
    		if(trim($_POST['username']=='')){
    			$this->error('用户不能为空');
    		}
    		$where['username'] = $_POST['username'];
    		$userArr = M('user')->where($where)->find();
    		if($userArr){
    			if($userArr['password'] != md5(substr(md5($_POST['password']),-8,10))){
    				$this->error('密码输入错误');
    			}
    			$_SESSION['uid'] = $userArr['uid'];
				$_SESSION['username'] = $userArr['username'];
				$_SESSION['BBL_IS_LOGINED'] = 1;
				$this->redirect('index/index');
				exit;
    		}
    		else{
    			$this->error('用户不存在');
    		}
    	}
    	$this->display();
    }
    // 清空历史
    public function deletehis(){
    	if(!$_SESSION['uid']){
    		die('请先登陆');
    	}
    	$where['uid'] = $_SESSION['uid'];
    	$isBool = M('history')->where($where)->delete();
    	if($isBool){
    		$this->success('清空成功','index/index');
    	}
    	else{
    		$this->error('清空失败');
    	}
    }

    // 固定api
    public function apilist(){
    	$this->display();
    }


    // 卢家妈妈登陆
    public function loginljmm(){
    	// $username = '555ML';
		$username = '卢家妈妈';
		$password = '123456';
		$curlPost = 'user_name='.urlencode($username).'&password='.urlencode($password);

		$ch = curl_init();//初始化curl
		// curl_setopt ($ch, CURLOPT_PROXY,'127.0.0.1:8888');
		curl_setopt($ch,CURLOPT_URL,'http://test.bbl.com/index.php?app=member&act=login&ajax');//抓取指定网页
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36');
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost); 
		// dump($this->cookiePath);
		curl_setopt($ch,CURLOPT_COOKIEJAR,$this->cookiePath);
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		// print_r($data);//输出结果

		if($data){
			// dump('登陆成功!!!');
			echo '<BR><a href="'.__URL__.'">返回</a>';
			// $this->success('登陆成功','index/index');
		}
    }


	public function quit(){
		session('[destroy]'); // 销毁session
		$this->redirect('Index/index');
	}

   	protected function requestUrl($url='',$curlpost=array(),$isChange=true){
   		if($isChange){
   			$url = str_replace('www.baibailai.com', $this->domain, $url);
   		}
		$ch = curl_init($url);
		// curl_setopt ($ch, CURLOPT_PROXY,'127.0.0.1:8888');  
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36');
		// dump($curlpost);
		
		if(!empty($curlpost)){
			curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
			// http_build_query解决多维数组的问题
			if(isset($_FILES)&&!empty($_FILES)){
				curl_setopt($ch, CURLOPT_POSTFIELDS, ($curlpost));
			}
			else{
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlpost));
			}
			
		}
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookiePath);
		$result=curl_exec($ch);
		curl_close($ch);
		// dump($result);
		return $result;
   	}

   	Public function upload(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		// $upload->maxSize  = 3145728 ;// 设置附件上传大小
		// $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  'Public/Uploads/';// 设置附件上传目录
		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		}
		return $info;
	}


}