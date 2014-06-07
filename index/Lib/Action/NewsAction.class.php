 <?php
// // 前台

class NewsAction extends CommAction {
        public function state(){
            $sort = M('sort');
            if(isset($_GET['sid'])){
                $where['path']=$_GET['sid'];
            }
            else{
                $where['path']=',000000';
            }
            dump($_GET);
            $where['ifmenu']='1';
            $sortArr = $sort->field('id,name,method,path')->where($where)->order('norder asc')->select();
            dump($sortArr);
            foreach ($sortArr as $key => $value) {
                // echo '<a href="'.__APP__.'/News/detail/path/'.$value['path'].'/id/'.$value['id'].'">'.$value['name'].'</a>';
                $path = $value['path'];
                $id = $value['id'];
                $name = $value['name'];
                echo "<a href='".__APP__."/News/detail/path/{$path}/id/{$id}'>{$name}</a>";
                echo '<br>';
            } 
            // $_GET['detail'];
            // dump($_GET);
            // 子分类
                
            $this->assign('sortArr',$sortArr);
            // 分类内容
            $this->assign('content',$content);

            $this->display();
        }
            // $a=10;
            // $b=100;
            // echo $a.$b;//10100
    // 内容
    public function detail(){
            $sort = M('news');
            $str = $_GET['path'].','.$_GET['id'];
            $where['sort']= $str;
            $detail = $sort->field('sort,title,description,content')->where($where) ->order('norder asc')->select();
            dump($detail);
            $this->assign('detail',$detail);
            
            $this->display();
        
      }  
}