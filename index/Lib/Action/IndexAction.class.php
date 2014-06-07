<?php
// 前台

class IndexAction extends CommAction {
    public function index(){
    	// dump($_SERVER);
    	$sort = M('sort');
    	$where['deep']='1';
    	$where['ifmenu']='1';
		$jsArr = $sort->field('id,name,method')->where($where)->order('norder asc')->select();
		$this->assign('jsArr',$jsArr);
		// dump($jsArr);
        $this->display();

    }
    public function detail(){
        $this->display();
    }

    public function inter(){
        $this->display();
    }

}