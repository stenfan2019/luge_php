<!DOCTYPE html>
<html lang="zh">
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <title>含羞草实习所www.hxcsxs.org</title> 
  <meta name="description" content="成人视频" /> 
  <meta name="keywords" content="含羞草实习所" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> 
  <link rel="shortcut icon" href="/favicon.ico" /> 
  <link rel="stylesheet" type="text/css" href="/static/css/login.css" /> 
  <link id="layuicss-laydate" rel="stylesheet" href="/static/css/laydate.css?v=5.0.9" media="all" />
  <link id="layuicss-layer" rel="stylesheet" href="/static/css/layer.css?v=3.1.1" media="all" />
  <link id="layuicss-skincodecss" rel="stylesheet" href="/static/css/code.css" media="all" /> 
  <script src="/static/js/jquery.js"></script>
<script src="/static/js/jquery.autocomplete.js"></script>
<script src="/static/js/jquery.superslide.js"></script>
<script src="/static/js/jquery.base.js"></script>
<style>
#weixin-tip {display: none;position: fixed;left: 0;top: 0;background: rgba(0,0,0,0.8);filter: alpha(opacity=80);width: 100%;height: 100%;z-index: 1000;}
#weixin-tip p {text-align: center;margin-top: 10%;padding: 0 5%;position: relative;}
#weixin-tip .close {color: #fff;padding: 5px;font: bold 20px/20px simsun;text-shadow: 0 1px 0 #ddd;position: absolute;top: 0;left: 5%;}
</style> 
 </head> 
  <section class="input_form login_form">
   <div class="loginHint_wrapper">
    <h1>登錄</h1> 
    <p class="bold">用戶首次使用：</p> 
    <p class="normal">請點擊“立即註冊”輸入郵箱並設置密碼，點擊下壹步即可加入成為會員，壹個帳號讓妳體驗所有娛樂。</p>
   </div> 
   <form  method="post" id="fm" action="">
    <div class="devided_line">
     <p>Login</p>
    </div> 
    <div class="input_field">
     <span class="input_fieldTitle">用戶名</span> 
     <span id="errorAccount" class="input_errorMsg"></span> 
     <input type="text" maxlength="32" id="user_name" name="user_name" placeholder="填寫正確的郵箱賬號" tabindex="1" style="padding-left: 8px;" />
    </div> 
    <div class="input_field">
     <span class="input_fieldTitle">密碼</span> 
     <span id="errorPasswd" class="input_errorMsg"></span> 
     <input type="Password" id="user_pwd" name="user_pwd" placeholder="請輸入6-12字密碼" tabindex="2" style="padding-left: 8px;" />
    </div> 
    <div class="input_field">
     <input type="button" id="btn_submit" value="立即登錄" onclick="login(this)" class="filledTypeBtn" /> 
     <div style="margin-top: 15px; padding-bottom: 10px;">
      <a href="/reg.html" tabindex="5" class="lostpw" style="padding-right: 20px;">立即註冊</a>
     </div>
    </div>
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
   </form>
  </section> 
  <script type="text/javascript">

	$(function(){
		$("body").bind('keyup',function(event) {
			if(event.keyCode==13){ $('#btnLogin').click(); }
		});
		$('#btn_submit').click(function() {
			if ($('#user_name').val()  == '') { alert('請輸入用戶郵箱！'); $("#user_name").focus(); return false; }
			if ($('#user_pwd').val()  == '') { alert('請輸入密碼！'); $("#user_pwd").focus(); return false; }
			if ($('#verify').val()  == '') { alert('請輸入驗證碼！'); $("#verify").focus(); return false; }

			$.ajax({
				url: "/login.html",
				type: "post",
				dataType: "json",
				data: $('#fm').serialize(),
				beforeSend: function () {
					$("#btn_submit").val("loading...");
				},
				success: function (r) {
					if(r.code==0){
						location.href="/";
					}
					else{
						alert(r.msg);
						$('#verify_img').click();
					}
				},
				complete: function () {
					$("#btn_submit").val("立即登錄");
				}
			});

		});
	});

</script>
 </body>
</html>