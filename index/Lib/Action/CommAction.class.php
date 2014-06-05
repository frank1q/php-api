<?php
// 公共类（基类）
class CommAction extends Action {

	// public  protected private
	
	// 检测是否登陆
    public function _initialize(){
        if(!isset($_SESSION['Apil_Login'])){
            // 跳转到登陆页面
            $this->redirect('Longin/login');
        }

    }
	// 用户密码加密
	protected function newPwd($password){
		return md5(substr(md5($password), 7,-7));
	}


}