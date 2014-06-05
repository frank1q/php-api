<?php
class LonginAction extends CommLoginAction {
public function login(){
    	$this->display();
    }
    public function doLogin(){
        $username=trim($_POST['username']);
		$where['account'] = $username;
    	$userArr = M('members')->where($where)->find();
        $mima=trim($_POST['password']);
    	$newpsd = $this->newPwd($mima);
    	if($userArr){
    		if($newpsd!=$userArr['password']){
    			$this->error('密码出错');
				
    		}
    		else{
    			$_SESSION['Apil_Login'] = 1;
    			$_SESSION['uid'] = $userArr['uid'];
    			$_SESSION['username'] = $userArr['username'];
    			$this->redirect('Index/index');
    		}
    	}
    	else{
    		$this->error('用户名不存在');
    	}
    }
}