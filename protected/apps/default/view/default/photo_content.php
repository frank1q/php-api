<?php if(!defined('APP_NAME')) exit;?>
<link href="__PUBLIC__/css/highslide.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="__PUBLIC__/js/highslide.js"></script>
<script language="javascript">
hs.graphicsDir = '__PUBLIC__/images/graphics/';
hs.wrapperClassName = 'wide-border';
hs.showCredits = false;
</script>
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
             <h1 class="con-tit">{$info['title']}</h1>
             <p class="con-info">发布日期：{date($info['addtime'],Y-m-d H:m:i)}&nbsp;&nbsp;点击量：{$info['hits']}</p>
             <p class="con-instr">{$info['content']['content']}<br>
             <div class="pagelist yx-u">{$info['content']['page']}</div>
               <span class="tags"> TAGS:
              {for $i=0;$i<10;$i++}
                 {if !empty($info['tags'][$i])} 
                    <a href="{url('default/index/search',array('type'=>'all','keywords'=>urlencode($info['tags'][$i])))}">{$info['tags'][$i]}</a>
                 {/if}
              {/for}
              </span>
             </p>
             <ul class="prlist yx-u">
                {loop $photolist $vo}
                <li><A onClick="return hs.expand(this)" title="{$vo['tit']}" href="{$PhotoImgPath}{$vo['picture']}"><img width="145" height="110" alt="{$vo['tit']}" class="box" src="{$PhotoImgPath}thumb_{$vo['picture']}"></A><div class="highslide-caption">{$vo['tit']}</div></li>
                {/loop} 
             </ul>
             
             <ul class="next">
                 <li>上一图集：{if !empty($upnews)}<a href="{url($upnews['method'],array('col'=>$sorts[$pid]['ename'],'id'=>$upnews['id']))}" onFocus="this.blur()">{$upnews['title']}</a>{else}没有了....{/if}</li>
                <li>下一图集：{if !empty($downnews)}<a href="{url($downnews['method'],array('col'=>$sorts[$pid]['ename'],'id'=>$downnews['id']))}" onFocus="this.blur()">{$downnews['title']}</a>{else}没有了....{/if}</li>
             </ul>
           {if !empty($reles)}
                    <div class="bock-tit"><h2>关联信息</h2></div>
                     <ul class="bock-list">
                     {loop $reles $vo}
                       <li><a class="w220" style="color:{$vo['color']}" title="{$vo['title']}" target="_blank" href="{$vo['url']}">{$vo['title']}</a><span>{date($vo['addtime'],Y-m-d)}</span></li>
                     {/loop}
                     </ul>
           {/if}
       </div>
    </div>
    {include file="prightCom"}
</div>
</div>