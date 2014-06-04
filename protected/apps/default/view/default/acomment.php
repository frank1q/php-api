 <?php if(!defined('APP_NAME')) exit;?>   
      <script type="text/javascript" charset="utf-8" src="__PUBLIC__/kindeditor/kindeditor.js"></script>
       <script type="text/javascript">
       KindEditor.ready(function(K) {
       K.create('.editori', {
           allowPreviewEmoticons : false,
          allowImageUpload : false,
          items : [
            'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
            'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
            'insertunorderedlist', '|', 'emoticons', 'image', 'link']

         });
       });
        //重载验证码
         function fleshVerify()
        {
            var timenow = new Date().getTime();
            document.getElementById('verifyImg').src= "{url('index/verify')}/"+timenow;
        }
       </script>
        <!--评论表单-->
         <form action="{url('column/index',array('col'=>100022))}" method="post" id="info" >
          <table class="form_box">
            <input type="hidden" name="type" value="1"><!--评论的类型,用于区分于其他图集、单页等评论-->
             <input type="hidden" name="aid" value="{$info['id']}"> <!--资讯ID-->
             <input type="hidden" name="comby" value="{$auth['nickname']}"><!--会员登陆后的昵称-->
            <tr>
               <td align="right" width="80">评论内容：</td>
               <td align="left"><textarea class="editori" name="comcontent" style="width:100%;height:90px;visibility:hidden;"></textarea></tr>
            </tr>
                <td align="right">验证码：</td> 
                <td><input type="text" name="checkcode" id="checkcode" class="intext" size="4">&nbsp;<img src="{url('index/verify')}" height="20" width="50" style=" cursor:hand;" alt="如果您无法识别验证码，请点图片更换" onClick="fleshVerify()" id="verifyImg"/></td>
             </tr>
             <tr>
                <td width="80"></td>
                <td align="left"> <input type="submit" value="评论" class="yx-button"></td>
            </tr>
          </table>
        </form>

        
         <!--评论列表-->
          <ul style="padding:0 10px">         
            {comment:{extable=(extend_conment) order=(id desc) where=(aid=#$info['id']# AND type='1' AND ispass='1')}}<!--如果不需要后台审核就显示则 去掉"AND ispass='1'"-->
               <li>
                  <div class="book-list-info">{if empty($comment['comby'])} "游客" {else} "{$comment['comby']}" {/if}&nbsp;&nbsp;&nbsp;  IP:{$comment['ip']} &nbsp;&nbsp;&nbsp; {date($comment['addtime'],Y-m-d H:m:i)}</div>
                  <div class="book-list-con"> {html_out($comment['comcontent'])} </div>
               </li>
            {/comment}
           </ul>