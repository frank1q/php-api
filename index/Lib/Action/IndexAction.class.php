<?php
// 前台

class IndexAction extends CommAction {
    public function index(){
        
        
        $this->display();
    }
    public function index1(){
    	// dump($_SERVER);
    	$sort = M('sort');
    	$where['deep']='1';
    	$where['ifmenu']='1';
		$jsArr = $sort->field('id,name,method,path')->where($where)->order('norder asc')->select();
        // echo '<br><br><br>';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else{
            $id = $jsArr[0]['id'];
        }
        $this->assign('id',$id);
        $str = ',000000'.','.$id;
        $where1['path']=$str;
        $where1['ifmenu']='1';
        $sortArr = $sort->field('id,name,method,path')->where($where1)->order('norder asc')->select();      
        // dump($sortArr);
        $news = M('news');

        if(isset($_GET['sortid'])&& is_numeric($_GET['sortid'])){
            $whereall['sort'] = $str.','.$_GET['sortid'];
            $sortid = 'sortid/'.$_GET['sortid'].'/';
        }
        else{
            $strlike = "%".$str."%";
            $whereall['sort']= array('like',$strlike);  
            // $sortid = $sortArr[0]['id'];
            $sortid = '';
        }
        $this->assign('sortid',$sortid);
        // dump($whereall);
        // exit;
        $newsArr = $news->field('id,title')->where($whereall)->order('norder asc')->select();
        
        // dump($newsArr);
        if(isset($_GET['cid'])){
            $contentID = $_GET['cid'];
        }
        else{
            $contentID = $newsArr[0]['id'];
        }
        // dump($contentID);
        $where3['id']= $contentID;
        $content = $news->field('id,title,content')->where($where3)->order('norder asc')->find();
        // dump($content);
        
        $this->assign('jsArr',$jsArr);
        $this->assign('sortArr',$sortArr);
        $this->assign('newsArr',$newsArr);
        $this->assign('content',$content);
        $this->display();
        
    }

    public function detail(){
        $this->display();
    }

    public function inter(){
        $this->display();
    }

}