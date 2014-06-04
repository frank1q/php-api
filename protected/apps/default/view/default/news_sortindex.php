<?php if(!defined('APP_NAME')) exit;?>
<div id="Main">
<div class="adv">
    <img src="__PUBLICAPP__/images/banner.png">
</div>
       <div class="box sortindex">
           <div class="bock-tit">
           <h3>
               当前位置：<a href="{url()}">首页</a> >
               {loop $daohang $vo}
                     <a href="{$vo['url']}">{$vo['name']}</a> >
               {/loop}
           </h3>
           </div>

           <div class="exsort">
        <span>{$sorts['100025']['name']}:</span>
         <?php $sortnow=getcsort($sorts,'100025',$type);?>
         {if $newexsort=subexsort($exsort,$sortnow)}
            <a  href="{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>$newexsort))}">全部</a>
          {else} 
            <a  href="{url('column/index',array('col'=>$col,'page'=>1))}">全部</a>
         {/if}
        {loop $sortnow $key $vo}
            {if strpos($exsort,strval($key))!==false}<!--已选中的栏目-->
               <a class="sorton" href="{if $newexsort}{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>subexsort($exsort,$key)))}{else}{url('column/index',array('col'=>$col,'page'=>1))}{/if}">{$vo['name']}</a>
            {else}<!--没选中的栏目-->
               <a href="{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>addexsort($sorts,$exsort,$key,$sortnow)))}">{$vo['name']}</a>
            {/if}
        {/loop}
           </div>
           <!--多选条件演示开始-->
           <div class="exsort">
          <span>{$sorts['100036']['name']}:</span>
          <?php $sortnow=getcsort($sorts,'100036',$type);?>
           {if $newexsort=subexsort($exsort,$sortnow)}
              <a href="{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>$newexsort))}">全部</a>
           {else} 
              <a href="{url('column/index',array('col'=>$col,'page'=>1))}">全部</a>
           {/if}
        {loop $sortnow $key $vo}
            {if strpos($exsort,strval($key))!==false}<!--已选中的栏目-->
              <a class="sorton" href="{if $newexsort}{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>subexsort($exsort,$key)))}{else}{url('column/index',array('col'=>$col,'page'=>1))}{/if}">{$vo['name']}</a>
            {else}<!--没选中的栏目-->
              <a href="{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>addexsort($sorts,$exsort,$key)))}">{$vo['name']}</a>
            {/if}
        {/loop}
           </div>
           <!--多选条件结束-->
           <div class="exsort">
        <span>{$sorts['100047']['name']}:</span>
        <?php $sortnow=getcsort($sorts,'100047',$type);?>
           {if $newexsort=subexsort($exsort,$sortnow)}
            <a  href="{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>$newexsort))}">全部</a>
           {else} 
            <a  href="{url('column/index',array('col'=>$col,'page'=>1))}">全部</a>
           {/if}
        {loop $sortnow $key $vo}
            {if strpos($exsort,strval($key))!==false}<!--已选中的栏目-->
              <a class="sorton"  href="{if $newexsort}{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>subexsort($exsort,$key)))}{else}{url('column/index',array('col'=>$col,'page'=>1))}{/if}">{$vo['name']}</a>
            {else}<!--没选中的栏目-->
              <a href="{url('column/index',array('col'=>$col,'page'=>1,'exsort'=>addexsort($sorts,$exsort,$key,$sortnow)))}">{$vo['name']}</a>
            {/if}
        {/loop}
           </div>

        <div style="clear:both">
           {loop $alist $vo}
            <div class="arlist">
              <a style="color:{$vo['color']}" onFocus="this.blur()" title="{$vo['title']}" href="{$vo['url']}" target="_blank"><h2>{$vo['title']}</h2></a>
              <span>{date($vo['addtime'],Y-m-d H:m:i)}&nbsp;&nbsp;&nbsp;&nbsp;点击:{$vo['hits']}</span>
                 {if !empty($vo['exsort'])}
                  <span class="tags"> 类别(副栏目):
                    {loop $vo['exsort'] $v}
                       {$sorts[$v]['name']}/
                    {/loop}
                    </span>
                 {/if}
              <p>{$vo['description']}......</p>
              <a class="detail" href="{url('column/index',array('id'=>$vo['id']))}">更多详细>></a>
           </div>
           {/loop}
         </div>
           <div class="pagelist yx-u">{$page}</div>
       </div>
</div>