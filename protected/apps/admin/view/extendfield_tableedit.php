<?php if(!defined('APP_NAME')) exit;?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__PUBLICAPP__/css/back.css" type=text/css rel=stylesheet>
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script  type="text/javascript" language="javascript" src="__PUBLIC__/js/jquery.skygqCheckAjaxform.js"></script>
<script language="javascript">
  $(function ($) { 
	//行颜色效果
	$('.all_cont tr').hover(
	function () {
        $(this).children().css('background-color', '#f2f2f2');
	},
	function () {
        $(this).children().css('background-color', '#fff');
	});
   //表单验证
	var items_array = [
		{ name:"tname",simple:"用途描述",focusMsg:''}
	];

	$("#info").skygqCheckAjaxForm({
		items			: items_array
	});
  });
</script>
<title>自定义表描述修改</title>
</head>
<body>
<div class="contener">
<div class="list_head_m">
           <div class="list_head_ml">当前位置：【自定义表描述修改】</div>
        </div>
        <form  action="{url('extendfield/tableedit')}"  method="post" id="info" name="info" >
        <table class="all_cont" width="100%" border="0" cellpadding="5" cellspacing="1"   > 
          <tr>
            <td align="right" width="200">用途描述：</td>
            <td align="left"><input name="tname" id="tname" type="text" value="{$info['name']}" /><input name="id" type="hidden" value="{$info['id']}" /></td>
            <td class="inputhelp"></td>
          </tr>
          <tr>
            <td align="right">表名：</td>
            <td align="left">{$info['tableinfo']}</td>
            <td class="inputhelp"></td>
          </tr>
          <tr>
            <td></td>
            <td colspan="2" align="left"><input type="submit" class="btn btn-primary btn-small" value="修改"></td>
          </tr>           
        </table>

</form>
</div>
</body>
</html>
