<?php if(!defined('APP_NAME')) exit;?>
<!--html代码运行插件-->
<script type="text/javascript" src="__PUBLIC__/js/htmlrun.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function() {
   $(".content").contents().find("img").each(function(){//限制内容中图片大小
       if($(this).width()>600){
         $(this).height($(this).height()*(600/$(this).width()));
         $(this).width(600);
         $(this).wrap("<a href=" + $(this)[0].src + " target=_blank></a>");
     }
  });
   
  $.each($("pre.lang-html,pre.lang-css,pre.lang-js"), function(i,val){  
     var old=$(val).html();  
	 $(val).html('<textarea name="text" id="runcode'+i+'"cols="80"rows="10">'+old+'</textarea><br><input type="button" value="运行代码" onClick="runcode(runcode'+i+')" class="yx-button">&nbsp;<input type="button" value="保存代码" onClick="savecode(runcode'+i+')" class="yx-button">&nbsp;<input type="button" value="复制代码" onClick="copycode(runcode'+i+')" class="yx-button">&nbsp;<input type="button" value="剪切代码" onClick="cutcode(runcode'+i+')" class="yx-button">&nbsp;<input type="button" value="粘贴代码" onClick="pastecode(runcode'+i+')" class="yx-button">');
	 
 }); 
});
//]]>
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
           <p class="con-info">发布日期：{date($info['addtime'],Y-m-d H:m:i)}&nbsp;&nbsp;点击量：{$info['hits']}&nbsp;&nbsp; 信息来源：{$info['origin']} </p>
           <div class="yx-u content" id="content">
                {$info['content']['content']}<br>
             <span class="tags"> TAGS:
              {for $i=0;$i<10;$i++}
                 {if !empty($info['tags'][$i])} 
                    <a href="{url('default/index/search',array('type'=>'all','keywords'=>urlencode($info['tags'][$i])))}">{$info['tags'][$i]}</a>
                 {/if}
              {/for}
            </span>
           </div>
           {loop $extinfo $vo}
                <div>{$vo['name']}:{$vo['value']}</div>
           {/loop}
           
           <div class="pagelist yx-u">{$info['content']['page']}</div>

           {include file="acomment"}
           <ul class="next">
                 <li>上一篇：{if !empty($upnews)}<a href="{url($upnews['method'],array('col'=>$sorts[$pid]['ename'],'id'=>$upnews['id']))}" onFocus="this.blur()">{$upnews['title']}</a>{else}没有了....{/if}</li>
                <li>下一篇：{if !empty($downnews)}<a href="{url($downnews['method'],array('col'=>$sorts[$pid]['ename'],'id'=>$downnews['id']))}" onFocus="this.blur()">{$downnews['title']}</a>{else}没有了....{/if}</li>
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
    {include file="arightCom"}
</div>
</div>