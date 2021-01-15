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
        #weixin-tip {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(0,0,0,0.8);
            filter: alpha(opacity=80);
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

            #weixin-tip p {
                text-align: center;
                margin-top: 10%;
                padding: 0 5%;
                position: relative;
            }

            #weixin-tip .close {
                color: #fff;
                padding: 5px;
                font: bold 20px/20px simsun;
                text-shadow: 0 1px 0 #ddd;
                position: absolute;
                top: 0;
                left: 5%;
            }

    </style> 
 </head> 
 <body style=""> 
  <section class="input_form login_form"> 
   <div class="loginHint_wrapper"> 
    <h1>註冊賬號</h1> 
    <p class="bold">用戶首次使用：</p> 
    <p class="normal">輸入邮箱並設置密碼，點擊“註冊”即可加入成為會員，壹個帳號讓妳體驗所有娛樂。</p> 
   </div> 
   
   <form name="loginFrm" method="post" id="fm" action=""> 
    <div class="devided_line"> 
     <p>Register</p> 
    </div> 
    <div class="input_field"> 
			<div class="reg-group">
				<label class="bd-r" style="letter-spacing: normal;">账号</label>
				<input type="text" id="user_name" name="user_name"  style="padding-left:8px;" class="reg-control" placeholder="请使用邮箱作为账号">
			</div>
			<div class="reg-group">
				<label class="bd-r" style="letter-spacing: normal;">昵称</label>
				<input type="text" id="nickname" name="nick_name"  style="padding-left:8px;" class="reg-control" placeholder="请输入您的昵称">
			</div>
			<div class="reg-group">
				<label>密码</label>
				<input type="password" id="user_pwd" name="user_pwd"  style="padding-left:8px;" class="reg-control" placeholder="请输入您的登录密码">
			</div>
			<div class="reg-group">
				<label>确认密码</label>
				<input type="password" id="user_pwd2" name="user_pwd2"  style="padding-left:8px;" class="reg-control" placeholder="请确认您的登录密码">
			</div>
			
	<div class="input_field"> 
     <input class="filledTypeBtn" id="btn_submit" type="button" value="註冊" onclick="register(this)" /> 
    </div> 
     <div style="margin-top: 15px; padding-bottom: 10px;">
     <a href="/index.php/user/login.html" target="_blank" tabindex="5" class="lostpw" style="padding-right: 20px;">已有账号？直接登录</a>
	</div>
</div>
</form>
</section>  
 <script type="text/javascript">

    var countdown=60;
    function settime(val) {
        if (countdown == 0) {
            val.removeAttribute("disabled");
            val.value="獲取驗證碼";
            countdown = 60;
            return true;
        } else {
            val.setAttribute("disabled", true);
            val.value="重新發送(" + countdown + ")";
            countdown--;
        }
        setTimeout(function() {settime(val) },1000)
    }


		$("body").bind('keyup',function(event) {
			if(event.keyCode==13){ $('#btnLogin').click(); }
		});

        $('#btn_send_sms').click(function(){
            var ac = $('input[name="ac"]').val();
            var to = $('input[name="to"]').val();
            if(ac=='email') {
                var pattern = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                var ex = pattern.test(to);
                if (!ex) {
                    alert('郵箱格式不正確');
                    return;
                }
            }
            else if(ac=='phone') {
                var pattern=/^[1][0-9]{10}$/;
                var ex = pattern.test(to);
                if (!ex) {
                    alert('手機號格式不正確');
                    return;
                }
            }
            else{
                alert('參數錯誤');
                return;
            }


            settime(this);
            var data = $("#fm").serialize();

            $.ajax({
                url: "/index.php/user/reg_msg.html",
                type: "post",
                dataType: "json",
                data: data,
                beforeSend: function () {
                    //开启loading
                },
                success: function (r) {
                    alert(r.msg);
                },
                complete: function () {
                    //结束loading
                }
            });
        });

		$('#btn_submit').click(function() {
			if ($('#user_name').val()  == '') { alert('請輸入用戶！'); $("#user_name").focus(); return false; }
			if ($('#user_pwd').val()  == '') { alert('請輸入密碼！'); $("#user_pwd").focus(); return false; }
			if ($('#user_pwd2').val()  == '') { alert('請重復輸入密碼！'); $("#user_pwd2").focus(); return false; }
			if ($('#verify').val()  == '') { alert('請輸入驗證碼！'); $("#verify").focus(); return false; }

			$.ajax({
				url: "/index.php/user/reg.html",
				type: "post",
				dataType: "json",
				data: $('#fm').serialize(),
				beforeSend: function () {
					$("#btn_submit").val("loading...");
				},
				success: function (r) {
					alert(r.msg);
					if(r.code==1){
						location.href="/index.php/user/login.html";
					}
					else{
						$('#verify_img').click();
					}
				},
				complete: function () {
					$("#btn_submit").val("立即註冊");
				}
			});

		});


</script>
 </body>
</html>