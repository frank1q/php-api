<?php if(!defined('APP_NAME')) exit;?>
<div id="Main">
       <div class="box search-con">
           <div class="bock-tit"><h3>一共找到 <font style="color:red"> {$count} </font> 个结果 </h3></div>
           {loop $list $vo}
            <div class="arlist">
              <a  onFocus="this.blur()" title="{$vo['title']}" href="{$vo['url']}" target="_blank"><h2><?php echo str_replace($keywords,"<font style='color:red'>$keywords</font>",$vo['title']); ?></h2><!-- {if $vo['picturepath']}<img src="{$vo['picturepath']}">{/if} --></a>
              <span>{date($vo['addtime'],Y-m-d H:m:i)}&nbsp;&nbsp;&nbsp;&nbsp;点击:{$vo['hits']}</span>
              {for $i=1;$i<count($extfields);$i++}<!--自定义字段搜索结果-->
                  <span>{$extfields[$i]['name']}:<?php echo str_replace($keywords,"<font style='color:red'>$keywords</font>",$vo[$extfields[$i]['tableinfo']]); ?></span>
              {/for}
              <p><?php echo str_replace($keywords,"<font style='color:red'>$keywords</font>",$vo['description']); ?>......</p>
            </div>
          {/loop}
           <div class="pagelist yx-u">{$page}</div>
       </div>
</div>