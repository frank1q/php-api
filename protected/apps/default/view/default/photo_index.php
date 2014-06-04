<?php if(!defined('APP_NAME')) exit;?>
<div id="Main">
<div class="adv">
    <img src="__PUBLICAPP__/images/banner.png">
</div>
<div class="yx-g">
    <div class="yx-u-17-24">
       <div class="box index-big">
           <div class="bock-tit">
           <h3>
               当前位置：<a href="{url()}">首页</a> >
               {loop $daohang $vo}
                     <a href="{$vo['url']}">{$vo['name']}</a> >
               {/loop}
           </h3>
           </div>
            {loop $plist $vo}
                  <dl class="plist yx-u">
                     <dt><a href="{$vo['url']}" target="_blank"><img src="{$vo['picturepath']}" width="145" height="110"></a><span>{$vo['title']}</span></dt>
                     <dd>{$vo['description']}<br>
                       <span class="tags"> TAGS:
                         {for $i=0;$i<10;$i++}
                           {if !empty($vo['tags'][$i])} 
                              <a href="{url('default/index/search',array('type'=>'all','keywords'=>urlencode($vo['tags'][$i])))}">{$vo['tags'][$i]}</a>
                           {/if}
                         {/for}
                       </span>
                     </dd>
                     
                  </dl>
            {/loop}
            <div class="pagelist yx-u">{$page}</div>   
       </div>
    </div>
    {include file="prightCom"}
</div>
</div>