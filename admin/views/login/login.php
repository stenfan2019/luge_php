<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/login.css" media="all">
    <script src="/layuiadmin/layui/layui.js"></script>
    <script src="/layuiadmin/init.js"></script>
</head>
<body>

<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h2>登录管理系统</h2>
            <!--<p>layui 官方出品的单页面后台管理模板系统</p>-->
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="username"></label>
                <input type="text" name="username" id="username" lay-verify="required" placeholder="用户名"
                       class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="password"></label>
                <input type="password" name="password" id="password" lay-verify="required" placeholder="密码"
                       class="layui-input">
            </div>
            <div class="layui-form-item">
                <div class="layui-row">
                    <div class="layui-col-xs7">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-vercode"
                               for="login-vercode"></label>
                        <input type="text" name="vcode" id="login-vercode" lay-verify="required" placeholder="图形验证码"
                               class="layui-input">
                        <input type="hidden" name="captchaKey" value="<?=$captchaKey?>">
                    </div>
                    <div class="layui-col-xs5">
                        <div style="margin-left: 10px;">
                            <img src="<?=\yii\helpers\Url::to('captcha?captchaKey='.$captchaKey)?>" onclick="this.src=this.src+'&mm='+Math.random(100000,900000)" class="layadmin-user-login-codeimg">
                        </div>
                    </div>
                </div>
            </div>
            <!--           <div class="layui-form-item" style="margin-bottom: 20px;">
                           <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
                           <a href="forget.html" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
                       </div>-->
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login_submit" id="login_submit">登 入</button>
            </div>
        </div>
    </div>

    <!--<div class="ladmin-user-login-theme">
      <script type="text/html" template>
        <ul>
          <li data-theme=""><img src="{{ layui.setter.base }}style/res/bg-none.jpg"></li>
          <li data-theme="#03152A" style="background-color: #03152A;"></li>
          <li data-theme="#2E241B" style="background-color: #2E241B;"></li>
          <li data-theme="#50314F" style="background-color: #50314F;"></li>
          <li data-theme="#344058" style="background-color: #344058;"></li>
          <li data-theme="#20222A" style="background-color: #20222A;"></li>
        </ul>
      </script>
    </div>-->

</div>


<script>
    layui.use(['index', 'user', 'admin'], function () {
        var $ = layui.$
            , admin = layui.admin
            , form = layui.form;

        document.onkeydown = function (e) {
            var theEvent = window.event || e;
            var code = theEvent.keyCode || theEvent.which;
            if (code == 13) {
                $("#login_submit").click();
            }
        }

        form.render();  //刷新元素对象

        $("#username").focus();
        //提交
        form.on('submit(login_submit)', function (obj) {
            //请求登入接口
            admin.req({
                url: '/login?data=1' //实际使用请改成服务端真实接口
                , type: 'post'
                , data: obj.field
                , done: function (res) {
                    if (res.code == 0) {
                        //登入成功的提示与跳转
                        layer.msg('登入成功', {
                            offset: '15px'
                            , icon: 1
                            , time: 1000
                        }, function () {
                            location.href = '/index/'; //后台主页
                        });
                    } else {
                        //layer.msg(res.msg, {icon: 5});
                    }
                    //请求成功后，写入 access_token
                    /*layui.data(setter.tableName, {
                        key: setter.request.tokenName
                        ,value: res.data.access_token
                    });*/
                }
            });
        });
    });
</script>
</body>
</html>