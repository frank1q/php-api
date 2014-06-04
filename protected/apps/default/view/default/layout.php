<?php if(!defined('APP_NAME')) exit;?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="{$keywords}"/>
<meta name="description" content="{$description}"/>
<title>{$title}</title>
<link rel="stylesheet" href="__PUBLICAPP__/css/base.css" type="text/css">
<link rel="stylesheet" href="__PUBLICAPP__/css/default.css" type="text/css">
<link rel="stylesheet" href="__PUBLICAPP__/css/slider.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type='text/javascript' src='__PUBLICAPP__/js/menu.js'></script>
<script type="text/javascript">
//<![CDATA[
	//Scroll to top
	jQuery(function() {
		jQuery(window).scroll(function() {
			if(jQuery(this).scrollTop() != 0) {
				jQuery('#toTop').fadeIn();	
			} else {
				jQuery('#toTop').fadeOut();
			}
		});
		jQuery('#toTop').click(function() {
			jQuery('body,html').animate({scrollTop:0},300);
	});
});
//]]>
</script>
</head>
<body>
<div id="Header">
   <div class="Top yx-g">
      <div class="yx-u-2-5"><img src="__PUBLICAPP__/images/logo.png" class="top-logo"></div>
      <div class="yx-u-3-5">
        <div class="Top-right">
          <div class="member-info">
          {if !$memberoff}<!--判断会员中心app是否开启-->
             {if !empty($auth)}<!--判断会员是否登陆-->
                <img src="{$auth['headpic']}" width="30" height="30"> 用户：{$auth['nickname']}&nbsp;&nbsp; 上次登录IP：{$auth['lastip']}&nbsp;&nbsp;<a href="{url('member/index/index')}">【会员中心】</a>&nbsp;<a href="{url('member/index/logout')}">【退出】</a>
              {else}
                <a class="yx-button" href="{url('member/index/login')}">登录</a>&nbsp;<a class="yx-button" href="{url('member/index/regist')}">注册</a>&nbsp;
                {if $openapi} <a class="openapi" href="{$openapi['sinaurl']}"><img src="__PUBLIC__/openapi/images/sina_login_btn.png"></a>&nbsp;&nbsp;<a class="openapi" href="{$openapi['qqurl']}"><img src="__PUBLIC__/openapi/images/qq_login.gif"></a>{/if}
             {/if}
           {/if}
          </div>
          <div class="searchbox">
              <div class="searchinput">
              <form method="get" action="{url('index/search')}">
                    <span class="tags">TAGS:
                        {tag:{table=(tags) field=(name) order=(hits desc,id desc) limit=(5)}}
                           <a href="{url('default/index/search',array('keywords'=>urlencode($tag['name']),'type'=>'all'))}">[tag:name]</a>
                        {/tag}...&nbsp;&nbsp;
                     </span>
                     <input name="r" type="hidden" value="default/index/search" />
                     <input type="text"  name="keywords" value="" class="search-input">
                     <select name="type">
                       <option value="all">=全部=</option>
                       <option value="news">=文章=</option>
                       <option value="photo">=图集=</option>
                       {loop $sorts $key $vo}
                         {if ($vo['type']==1 or $vo['type']==2) and $vo['deep']==1 and $vo['ifmenu']}
                             <option {if $id==$key} selected {/if} value="{$key}">{$vo['name']}</option>
                         {/if}
                       {/loop}
                     </select>
                     <input type="submit" value="搜 索" class="yx-button">
               </form>
               </div>
           </div>
         </div>
      </div>
   </div>
   <div id="menu">
    <ul class="menu"><!--一级菜单-->
      <li><a {if empty($rootid)} class="current" {/if} href="{url()}"><span>首页</span></a></li>
      {loop sorttree($sorts) $k1 $v1}
         <li {if $rootid==$k1} class="current" {/if} ><a href="{$v1['url']}"><span>{$v1['name']}</span></a>
             <ul><!--二级菜单-->
                 {loop $v1['c'] $v2}
                    <li><a href="{$v2['url']}"><span>{$v2['name']}</span></a>
                        <ul><!--三级菜单-->
                            {loop $v2['c'] $v3}
                                <li><a href="{$v3['url']}"><span>{$v3['name']}</span></a>
                                    <ul><!--四级菜单-->
                                        {loop $v3['c'] $v4}<li><a href="{$v4['url']}"><span>{$v4['name']}</span></a></li>{/loop}
                                    </ul>
                                </li>
                            {/loop}
                        </ul>
                    </li>
                 {/loop}
             </ul>
          </li>
       {/loop}
     </ul>
   </div>
</div>

{include file="$__template_file"} 
<div id="Foot">
   <div class="foot-con">
       <img class="logo" src="__PUBLICAPP__/images/Lmark.png">
       <div class="copy">
           {loop $sorts $key $vo}  
             {if $vo['ifmenu']}        
                {if $vo['deep']==1}
                    <a target="_blank" href="{$vo['url']}">{$vo['name']}</a> -
                {/if}
             {/if}
           {/loop}<br>
          Copyright @ 2012-2014 Yxcms Inc. All right reserved.Powered By <a target="_blank" title="免费版不可去除此版权" href="http://www.yxcms.net">YXcms</a><br>
         联系电话:{$telephone}&nbsp;&nbsp;&nbsp;&nbsp;QQ:{$QQ}&nbsp;&nbsp;&nbsp;&nbsp;站长邮箱：{$email}&nbsp;&nbsp;&nbsp;&nbsp;地址:{$address}&nbsp;&nbsp;&nbsp;&nbsp;ICP:{$icp}
       </div>
   </div>
</div>
<div id="toTop">Back to top</div>
</body>
</html>