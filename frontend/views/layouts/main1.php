<!DOCTYPE html>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport" />
<title><?=$this->context->seo_title ?>-陆蛤視頻、www.lugetv.com</title>
<meta name="description" content="成人視頻" />
<meta name="keywords" content="陆蛤視頻" />
<link rel="shortcut icon" href="/favicon.ico" />
<link href="/static/css/bootstrap.css"rel="stylesheet" />
<link href="/static/css/font-awesome.min.css"rel="stylesheet" />
<link href="/static/css/home.css?v=1029"rel="stylesheet" />
<link href="/static/css/layui.css" rel="stylesheet" />
<link id="layuicss-laydate" rel="stylesheet" href="/static/css/laydate.css?v=5.0.9" media="all" />
<link id="layuicss-layer" rel="stylesheet" href="/static/css/layer.css?v=3.1.1" media="all" />
<link id="layuicss-skincodecss" rel="stylesheet" href="/static/css/code.css" media="all" />
<script src="/static/js/jquery.min.js"></script>
</head>
<body style="">
	<header id="header">
		<?php $this->beginContent('@app/views/layouts/public/header.php') ?>
        <?php $this->endContent() ?>
		<?php $this->beginContent('@app/views/layouts/public/menu.php') ?>
        <?php $this->endContent() ?>
	</header>

	<div id="container">
	    <?php $this->beginContent('@app/views/layouts/public/search.php') ?>
        <?php $this->endContent() ?>
		<?=$content?>
	</div>
	  <?php $this->beginContent('@app/views/layouts/public/footer.php') ?>
      <?php $this->endContent() ?>
</body>
</html>