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
            <ul class="prlist yx-u">
               {loop $plist $vo}
                  <li><a href="{$vo['url']}" target="_blank"><img class="box" src="{$vo['picturepath']}" width="145" height="110"></a><h2>{$vo['title']}</h2><span>{date($vo['addtime'],Y-m-d H:m:i)}</span></li>
              {/loop}   
            </ul>
            <div class="pagelist yx-u">{$page}</div> 
       </div>
    </div>
    {include file="prightCom"}
</div>
</div>