<?php
class columnController extends commonController
{
	public function index()
	{
		$ename=in($_GET['col']);
		if(empty($ename)) throw new Exception('栏目名不能为空~', 404);
		$sortinfo=model('sort')->find("ename='{$ename}'",'id,name,ename,path,url,type,deep,method,tplist,keywords,description,extendid');
		$path=$sortinfo['path'].','.$sortinfo['id'];
		$deep=$sortinfo['deep']+1;
		$this->col=$ename;
		switch ($sortinfo['type']) {
			case 1://文章
				$this->newslist($sortinfo,$path,$deep);
				break;
			case 2://图集
				$this->photolist($sortinfo,$path,$deep);
				break;
			case 3://单页
				$this->page($sortinfo,$path,$deep);
				break;
            case 4://应用
				
				break;
			case 5://自定义
				
				break;
			case 6://表单
				$this->extend($sortinfo,$path,$deep);
				break;
			default:
				throw new Exception('未知的栏目类型~', 404);
				break;
		}
	}
        
	public function content()
	{
		$ename=in($_GET['col']);
		$id=intval($_GET['id']);
		if(empty($ename) || empty($id)) throw new Exception('参数错误~', 404);
		$this->col=$ename;
		$sortinfo=model('sort')->find("ename='{$ename}'",'type');
		switch ($sortinfo['type']) {
			case 1://文章
				$this->newscon($ename,$id);
				break;
			case 2://图集
				$this->photocon($id);
				break;
			default:
				throw new Exception('此类型下没有内容~', 404);
				break;
		}
	}

	protected function newslist($sortinfo,$path,$deep)
	{
		$listRows=empty($sortinfo['url'])?10:intval($sortinfo['url']);//每页显示的信息条数
        $where="(sort LIKE '{$path}%' OR exsort LIKE '%".$sortinfo['id']."%') AND ispass='1'";

		$_GET['exsort']=in($_GET['exsort']);
		if(!empty($_GET['exsort'])){
            $_GET['exsort']=str_replace('i'.$sortinfo['id'], '', $_GET['exsort']);
            $_GET['exsort']=str_replace($sortinfo['id'].'i', '', $_GET['exsort']);
            $_GET['exsort']=str_replace($sortinfo['id'], '', $_GET['exsort']);
            $exwhere=str_replace('i', '%', $_GET['exsort']);
            if(!empty($exwhere)){
            	$exwhere='%'.$exwhere.'%';
            	$where.=" AND exsort LIKE '{$exwhere}'";
            }
            $this->exsort=$_GET['exsort'];
		}
		$url=empty($_GET['exsort'])?url('column/index',array('col'=>$sortinfo['ename'],'page'=>'{page}')):url($sortinfo['method'],array('col'=>$sortinfo['ename'],'page'=>'{page}','exsort'=>$_GET['exsort']));
	    $limit=$this->pageLimit($url,$listRows);
		$count=model('news')->count($where);
		if(empty($sortinfo['extendid']))
		    $list=model('news')->select($where,'id,title,color,sort,exsort,addtime,origin,hits,method,picture,keywords,description','recmd DESC,norder desc,id DESC',$limit);
		else {
			$exid=$sortinfo['extendid'];
			$extables=model('extend')->select("id='{$exid}' or pid='{$exid}'","tableinfo","pid,norder DESC");
			if(empty($extables)) throw new Exception('自定义字段信息不存在~', 404);
			$list=model('news')->newsANDextend($extables,$path,$limit,$sortinfo['id'],$exwhere);
		}
		if(!empty($list)){
		   foreach ($list as $key=>$vo) {
			  $list[$key]['url']=Check::url($vo['method'])?$vo['method']:url($vo['method'],array('col'=>$sortinfo['ename'],'id'=>$vo['id']));
			  $list[$key]['sort']=substr($vo['sort'],-6);
			  $list[$key]['exsort']=explode(',', $vo['exsort']);
			  $list[$key]['picturepath']=$this->NewImgPath.$vo['picture'];
			  if(!empty($vo['keywords'])) $list[$key]['tags']=gettags($vo['keywords']);
		   }
		}
		$this->daohang=$this->crumbs($path);//面包屑导航
		$this->sortlist=$this->sortArray(0,$deep,$path);//子分类信息
		$this->alist=$list;
		$this->num=$count;
		$this->id=$sortinfo['id'];
		$this->pid=substr($sortinfo['path'],-6);
		$this->type=1;
		$this->page=$this->pageShow($count);
		$this->title=$sortinfo['name'].'-'.$this->title;//title标签
		if(!empty($sortinfo['keywords'])) $this->keywords=$sortinfo['keywords'];
		if(!empty($sortinfo['description'])) $this->description=$sortinfo['description'];
		$this->rootid=$this->getrootid($sortinfo['id']);//根节点id
		$tp=explode(',', $sortinfo['tplist']);
		$this->display($tp[0]);
	}
	protected function newscon($ename,$id)
	{
        $info=model('news')->find("id='{$id}' and ispass='1'");
        if(empty($info))  throw new Exception('内容不存在~', 404);
        model('news')->update("id='$id'","hits=hits+1");//点击
		//文章分页
		$page = new Page();
		$url =url('column/content',array('col'=>$ename,'id'=>$id));
		$info['exsort']=explode(',', $info['exsort']);
		$info['content'] = $page->contentPage(html_out($info['content']), '<hr style="page-break-after:always;" class="ke-pagebreak" />',$url,10,4); //文章分页
		//获取拓展数据
		$sortid=substr($info['sort'],-6,6);
		$tabid=model('sort')->find("id='{$sortid}'",'extendid');//获取拓展表
		if($tabid['extendid']!=0 && !empty($tabid['extendid'])){
			$tab=model('extend')->select("id='{$tabid['extendid']}' OR pid='{$tabid['extendid']}'",'id,name,tableinfo,type','id');//获取拓展表名和字段
			if(!empty($tab[0]['tableinfo'])){
				$extdata=model('extend')->Extfind($tab[0]['tableinfo'],"id='{$info['extfield']}'");	
				$extinfo=array();
				for($i=1;$i<count($tab);$i++){
					$extinfo[$tab[$i]['id']]=array('name'=>$tab[$i]['name'],'value'=>$extdata[$tab[$i]['tableinfo']],'type'=>$tab[$i]['type']);
				}
				$this->extinfo=$extinfo;//拓展信息
			}
		}
		//获取拓展数据结束
        $topsort=substr($info['sort'],0,14); //获取顶级类
		$upnews=model('news')->find("ispass='1'  AND id>'$id' AND sort like '{$topsort}%'",'id,title,method','id ASC');//上一篇
		$downnews=model('news')->find("ispass='1' AND id<'$id' AND sort like '{$topsort}%'",'id,title,method','id DESC');//下一篇
		$crumbs=$this->crumbs($info['sort']);//面包屑导航
		$lastCrumb=end($crumbs);
		$this->title=$info['title'].'-'.$lastCrumb['name'].'-'.$this->title;//title标题
		if(!empty($info['keywords'])) {
			$this->keywords=$info['keywords'];
			if(!empty($info['keywords'])) $info['tags']=gettags($info['keywords']);
		}
		if(!empty($info['description'])) $this->description=$info['description'];
		if(!empty($info['releids'])){
			$reles=model('news')->select("id in(".$info['releids'].") AND ispass=1",'id,title,color,addtime,method','recmd DESC,norder desc,id DESC',8);
			if(!empty($reles)){
				foreach ($reles as $key=>$vo) {
				    $reles[$key]['url']=Check::url($vo['method'])?$vo['method']:url($vo['method'],array('col'=>$ename,'id'=>$vo['id']));
			    }
			 $this->reles=$reles;
			}
		}
		$this->daohang=$crumbs;//面包屑导航
		$this->info=$info;
		$this->rootid=substr($info['sort'],8,6);
		$this->pid=substr($info['sort'],-6);
		if(strlen($info['sort'])>12) $this->ppid=substr($info['sort'],-13,6);
		$this->downnews=$downnews;
		$this->upnews=$upnews;
		$this->display($info['tpcontent']);
	}

	protected function photolist($sortinfo,$path,$deep)
	{
		$listRows=empty($sortinfo['url'])?10:intval($sortinfo['url']);//每页显示的信息条数
		$where="(sort LIKE '{$path}%' OR exsort LIKE '%".$sortinfo['id']."%') AND ispass='1'";
		$_GET['exsort']=in($_GET['exsort']);
		if(!empty($_GET['exsort'])){
            $_GET['exsort']=str_replace('i'.$sortinfo['id'], '', $_GET['exsort']);
            $_GET['exsort']=str_replace($sortinfo['id'].'i', '', $_GET['exsort']);
            $_GET['exsort']=str_replace($sortinfo['id'], '', $_GET['exsort']);
            $exwhere=str_replace('i', '%', $_GET['exsort']);
            if(!empty($exwhere)){
            	$exwhere='%'.$exwhere.'%';
            	$where.=" AND exsort LIKE '{$exwhere}'";
            }
           $this->exsort=$_GET['exsort'];
		}
		$url=empty($_GET['exsort'])?url('column/index',array('col'=>$sortinfo['ename'],'page'=>'{page}')):url('column/index',array('col'=>$sortinfo['ename'],'page'=>'{page}','exsort'=>$_GET['exsort']));
	    $limit=$this->pageLimit($url,$listRows);
		$count=model('photo')->count($where);
		if(empty($sortinfo['extendid']))
		  $list=model('photo')->select($where,'id,title,color,sort,exsort,addtime,hits,method,picture,keywords,description,photolist','recmd DESC,norder desc,id DESC',$limit);
		else {
			$exid=$sortinfo['extendid'];
			$extables=model('extend')->select("id='{$exid}' or pid='{$exid}'","tableinfo","pid,norder DESC");
			if(empty($extables)) throw new Exception('自定义字段信息不存在~', 404);
			$list=model('photo')->photoANDextend($extables,$path,$limit,$sortinfo['id'],$exwhere);
		}
		if(!empty($list)){
		   foreach ($list as $key=>$vo) {
			  $list[$key]['url']=Check::url($vo['method'])?$vo['method']:url($vo['method'],array('col'=>$sortinfo['ename'],'id'=>$vo['id']));
			  $list[$key]['sort']=substr($vo['sort'],-6);
			  $list[$key]['exsort']=explode(',', $vo['exsort']);
			  $list[$key]['pnum']=substr_count($list[$key]['photolist'],',')+1;
			  $list[$key]['picturepath']=$this->PhotoImgPath.'thumb_'.$vo['picture'];
			  if(!empty($vo['keywords'])) $list[$key]['tags']=gettags($vo['keywords']);
		   }
		}
		$this->title=$sortinfo['name'].'-'.$this->title;//title标签
		if(!empty($sortinfo['keywords'])) $this->keywords=$sortinfo['keywords'];
		if(!empty($sortinfo['description'])) $this->description=$sortinfo['description'];
		$this->daohang=$this->crumbs($path);//面包屑导航
		$this->sortlist=$this->sortArray(0,$deep,$path);//子分类信息
		$this->plist=$list;
		$this->num=$count;
		$this->id=$sortinfo['id'];
		$this->pid=substr($sortinfo['path'],-6);
		$this->type=2;
		$this->page=$this->pageShow($count);
		$this->rootid=$this->getrootid($sortinfo['id']);//根节点id
		$tp=explode(',', $sortinfo['tplist']);
		$this->display($tp[0]);
	}
	protected function photocon($id)
	{
	   $info=model('photo')->find("id='{$id}' and ispass='1'");
	   if(empty($info)) throw new Exception('内容不存在~', 404);

	   $info['exsort']=explode(',', $info['exsort']);
	   $page = new Page();
	   $info['content']=$info['content'] = $page->contentPage(html_out($info['content']), '<hr style="page-break-after:always;" class="ke-pagebreak" />',$url,10,4); //文章分页
	   model('photo')->update("id='$id'","hits=hits+1");//点击
	   if(!empty($info['conlist'])) $titar=explode(',',$info['conlist']);
	   if(!empty($info['photolist'])){
               $phoar=explode(',',$info['photolist']);
               $cont=sizeof($phoar);
               for($i=0;$i<$cont;$i++){
           	       $photolist[$i]['picture']=$phoar[$i];
           	       $photolist[$i]['tit']=$titar[$i];
                   //$tit.="'<p>$titar[$i]</p>',";
                   //$sphoto.="'".__ROOT__."/upload/photos/thumb_$phoar[$i]',";
                   //$bphoto.="'".__ROOT__."/upload/photos/$phoar[$i]',";
                }
                $this->photolist=$photolist;
                $this->num=$cont;
                //$this->assign(tit,substr($tit,0,-1));
                //$this->assign(sphoto,substr($sphoto,0,-1));
                //$this->assign(bphoto,substr($bphoto,0,-1));
	    }
		//获取拓展数据
		$sortid=substr($info['sort'],-6,6);
		$tabid=model('sort')->find("id='{$sortid}'",'extendid');//获取拓展表
		if($tabid['extendid']!=0 && !empty($tabid['extendid'])){
			$tab=model('extend')->select("id='{$tabid['extendid']}' OR pid='{$tabid['extendid']}'",'id,name,tableinfo,type','id');//获取拓展表名和字段
			if(!empty($tab[0]['tableinfo'])){
				$extdata=model('extend')->Extfind($tab[0]['tableinfo'],"id='{$info['extfield']}'");	
				$extinfo=array();
				for($i=1;$i<count($tab);$i++){
					$extinfo[$tab[$i]['id']]=array('name'=>$tab[$i]['name'],'value'=>$extdata[$tab[$i]['tableinfo']],'type'=>$tab[$i]['type']);
				}
				$this->extinfo=$extinfo;//拓展信息,用于循环调用
				$this->extdata=$extdata;//拓展信息,用于直接调用
			}
		}
		//获取拓展数据结束
        $topsort=substr($info['sort'],0,14); //获取顶级类
		$upnews=model('photo')->find("ispass='1'  AND id>'$id' AND sort like '{$topsort}%'",'id,title,method','id ASC',1);//上一篇
		$downnews=model('photo')->find("ispass='1' AND id<'$id' AND sort like '{$topsort}%'",'id,title,method','id DESC',1);//下一篇
		$crumbs=$this->crumbs($info['sort']);//面包屑导航
		$lastCrumb=end($crumbs);
		$this->title=$info['title'].'-'.$lastCrumb['name'].'-'.$this->title;//title标题
		if(!empty($info['keywords'])){
			$this->keywords=$info['keywords'];
			if(!empty($info['keywords'])) $info['tags']=gettags($info['keywords']);
		}
		if(!empty($info['description'])) $this->description=$info['description'];

		if(!empty($info['releids'])){
			$reles=model('photo')->select("id in(".$info['releids'].") AND ispass=1",'id,title,color,addtime,method','recmd DESC,norder desc,id DESC',8);
			if(!empty($reles)){
				foreach ($reles as $key=>$vo) {
				    $reles[$key]['url']=Check::url($vo['method'])?$vo['method']:url($vo['method'],array('col'=>$ename,'id'=>$vo['id']));
			    }
			 $this->reles=$reles;
			}
		}
        $this->daohang=$crumbs;//面包屑导航
		$this->info=$info;
		$this->rootid=substr($info['sort'],8,6);
		$this->pid=substr($info['sort'],-6);
		if(strlen($info['sort'])>12) $this->ppid=substr($info['sort'],-13,6);
		$this->downnews=$downnews;
		$this->upnews=$upnews;
		$this->display($info['tpcontent']);
	}

	protected function page($sortinfo,$path,$deep)
	{
		$info=model('page')->find("sort='{$path}'");
		$info['title']=$sortinfo['name'];
		//文章分页
		$page = new Page();
		$url = url('column/page',array('col'=>$sortinfo['ename'],'page'=>'{page}'));
		$info['content'] = $page->contentPage(html_out($info['content']), '<hr style="page-break-after:always;" class="ke-pagebreak" />',$url,10,4); //文章分页

		$this->sortlist=$this->sortArray(0,$deep,$path);//子分类信息
		$this->daohang=$this->crumbs($info['sort']);//面包屑导航
        $this->title=$sortinfo['name'].'-'.$this->title;//title标签
		if(!empty($sortinfo['keywords'])) $this->keywords=$sortinfo['keywords'];
		if(!empty($sortinfo['description'])) $this->description=$sortinfo['description'];
		$this->info=$info;
		$this->id=$sortinfo['id'];
		$this->pid=substr($sortinfo['path'],-6);
		$this->rootid=$this->getrootid($sortinfo['id']);//根节点id
		$this->display($sortinfo['tplist']);
	}

	protected function extend($sortinfo,$path,$deep)
	{
		$tableid=$sortinfo['extendid'];
        if(empty($tableid)) $this->error('表单栏目不存在~');
        $tableinfo = model('extend')->select("id='{$tableid}' OR pid='{$tableid}'",'id,tableinfo,name,type,defvalue','pid,norder DESC');
        if(empty($tableinfo)) $this->error('自定义表不存在~');
        $urls=explode('|', $sortinfo['url']);
        if (!$this->isPost()) {
           $tablename=$tableinfo[0]['tableinfo'];
           
           $listRows=intval($urls[0]);//每页显示的信息条数
           $url=url('column/index',array('col'=>$sortinfo['ename'],'page'=>'{page}'));
           $limit=$this->pageLimit($url,$listRows);
           $count=model('extend')->Extcount($tablename,"ispass='1'");//获取行数
           $list=model('extend')->Extselect($tablename,"ispass='1'",'','id desc',$limit);
           $this->list=$list;
           $this->id=$sortinfo['id'];
           //$this->title=$tableinfo[0]['name'];
           $this->tableinfo=$tableinfo;
           $this->daohang=$this->crumbs($path);//面包屑导航
           $this->sortlist=$this->sortArray(0,$deep,$path);//子分类信息
           $this->title=$sortinfo['name'];//title标签
           if(!empty($sortinfo['keywords'])) $this->keywords=$sortinfo['keywords'];
           if(!empty($sortinfo['description'])) $this->description=$sortinfo['description'];
           $this->rootid=$this->getrootid($sortinfo['id']);//根节点id
           $this->page=$this->pageShow($count);
           $this->display($sortinfo['tplist']);
        }else{
           session_starts();
           if($_POST['checkcode']!=$_SESSION['verify'] || empty($_SESSION['verify'])) $this->error('验证码错误，请重新输入');
           for($i=1;$i<count($tableinfo);$i++){
            if(is_array($_POST[$tableinfo[$i]['tableinfo']])){
               $data[$tableinfo[$i]['tableinfo']]=implode(',',$_POST[$tableinfo[$i]['tableinfo']]);
               $data[$tableinfo[$i]['tableinfo']]=$data[$tableinfo[$i]['tableinfo']]?in(deletehtml($data[$tableinfo[$i]['tableinfo']])):'';
            }else $data[$tableinfo[$i]['tableinfo']]=html_in($_POST[$tableinfo[$i]['tableinfo']]);
           }
           $data['ip']=get_client_ip();
           $data['ispass']=0;
           $data['addtime']=time();
           if(empty($urls[1])) $jump=$_SERVER['HTTP_REFERER'];
           else{
              $jurl=explode(',',$urls[1]);
              if(!empty($jurl[1])){
                $arr=explode('/',$jurl[1]);
                if(!empty($arr)){
                  $canshu=array();
                  foreach ($arr as $vo) {
                     $val=explode('=',$vo);
                     $canshu[$val[0]]=$val[1];
                  }
                }
              }
              $jump=url($jurl[0],$canshu); 
           }
           if(model('extend')->Extin($tableinfo[0]['tableinfo'],$data)) $this->success('提交成功请等待审核~',$jump);
           else $this->error('提交失败~');
         }
	}
}