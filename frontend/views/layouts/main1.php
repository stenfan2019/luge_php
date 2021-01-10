<!DOCTYPE html>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="width=device-width, initial-scale=1.0, user-scalable=0"
	name="viewport" />
<title>含羞草实习所www.hxcsxs.org</title>
<meta name="description" content="成人视频" />
<meta name="keywords" content="含羞草实习所" />
<link rel="shortcut icon" href="/favicon.ico" />
<link href="/static/css/bootstrap.css"rel="stylesheet" />
<link href="/static/css/font-awesome.min.css"rel="stylesheet" />
<link href="/static/css/home.css?v=1029"rel="stylesheet" />
<link href="/static/css/layui.css" rel="stylesheet" />
<link id="layuicss-laydate" rel="stylesheet" href="/static/css/laydate.css?v=5.0.9" media="all" />
<link id="layuicss-layer" rel="stylesheet" href="/static/css/layer.css?v=3.1.1" media="all" />
<link id="layuicss-skincodecss" rel="stylesheet" href="/static/css/code.css" media="all" />
<script src="/static/js/jquery.js"></script>
<script src="/static/js/jquery.autocomplete.js"></script>
<script src="/static/js/jquery.superslide.js"></script>
<script src="/static/js/jquery.base.js"></script>
<script>var maccms={"path":"","mid":"","url":"www.hxcsxs.org","wapurl":"www.hxcsxs.org","mob_status":"0"};</script>
<script src="/static/js/home.js"></script>

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