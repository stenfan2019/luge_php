<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/login.css" media="all">
    <script src="/layuiadmin/layui/layui.js"></script>
    <script src="/layuiadmin/jquery.min.js"></script>
    <script src="/layuiadmin/init.js"></script>
</head>

<body class="layui-layout-body">
<div id="LAY_app">
        <?= $content ?>
</div>

<script>
    layui.use('index');
</script>
</body>
</html>


    