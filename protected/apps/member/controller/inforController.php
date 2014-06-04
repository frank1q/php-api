<?php
class inforController extends commonController
{
  static protected $uploadpath='';//封面图路径
  public function __construct()
  {
     parent::__construct();
     if(!$this->auth['account']){
        if(empty($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER']=url('default/index/login');
        $this->error('您还没有登陆~',$_SERVER['HTTP_REFERER']);
     }
     $this->uploadpath=ROOT_PATH.'upload/member/image/';
  }
	    public function index()
	    {
        if(!$this->isPost()){
           $auth=$this->auth;
           $id=$auth['id'];
           $info=model('members')->find("id='{$id}'");
           $this->info=$info;
           $this->path=__ROOT__.'/upload/member/image/';
           $this->twidth=config('HEAD_W');
           $this->theight=config('HEAD_H');
           $this->display();
        }else{
           $id=intval($_POST['id']);

           $data['nickname']=in(trim($_POST['nickname']));
           $acc=model('members')->find("id!='{$id}' AND nickname='".$data['nickname']."'");
           if(!empty($acc['nickname'])) $this->error('该昵称已经有人使用~');
           if (empty($_FILES['headpic']['name']) === false){
                $tfile=date("Ymd");
                $imgupload= $this->upload($this->uploadpath.$tfile.'/',config('imgupSize'),'jpg,bmp,gif,png');
                $imgupload->saveRule='thumb_'.time();
                $imgupload->upload();
                $fileinfo=$imgupload->getUploadFileInfo();
                $errorinfo=$imgupload->getErrorMsg();
                if(!empty($errorinfo)) $this->alert($errorinfo);
                else{
                    if(!empty($_POST['oldheadpic'])){
                       $picpath=$this->uploadpath.$_POST['oldheadpic'];
                       if(file_exists($picpath)) @unlink($picpath);
                    }
                    $data['headpic']=$tfile.'/'.$fileinfo[0]['savename'];
                }      
          }

           $data['email']=$_POST['email'];
           $data['tel']=in($_POST['tel']);
           $data['qq']=in($_POST['qq']);
           model('members')->update("id='{$id}'",$data);
           $this->success('信息编辑成功~');
        }
	    }
      
      public function password()
      {
         if(!$this->isPost()){
           $this->display();
        }else{
           if($_POST['password']!=$_POST['surepassword']) $this->error('确认密码与新密码不符~');
           $auth=$this->auth;
           $id=$auth['id'];
           $info=model('members')->find("id='{$id}'",'password');
           $oldpassword=codepwd($_POST['oldpassword']);
           if($oldpassword!=$info['password']) $this->error('旧密码不正确~');
           
           $data['password']=codepwd($_POST['password']);
           model('members')->update("id='{$id}'",$data);
           $this->success('密码修改成功~');
        }
      }
      public function rmb()
      {
        $auth=$this->auth;
        $id=$auth['id'];
        $info=model('members')->find("id='{$id}'","rmb,crmb");
        $info['rrmb']=$info['rmb']-$info['crmb'];
        $this->info=$info;
        $this->display();
      }
      //头像剪切
  public function cutcover()
  {
    //文件保存目录
    $picname=in($_POST['name']);
    $thumb_image_location=$large_image_location=ROOT_PATH.'upload/member/image/'.$picname;
    $thumb_width=intval($_POST["thumb_w"]);//剪切后图片宽度
    $x1 = intval($_POST["x1"]);
    $y1 = intval($_POST["y1"]);
    $w =intval($_POST["w"]);
    $h = intval($_POST["h"]);
    if(empty($thumb_width)||empty($w)||empty($h)) exit(0);
    $scale = $thumb_width/$w;
    $cropped = resizeThumbnailImage($thumb_image_location,$large_image_location,$w,$h,$x1,$y1,$scale);
    if(empty($cropped)) echo 0;
    else echo $picname;
  }
}