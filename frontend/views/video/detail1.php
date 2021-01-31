<div id="video-section" class="fullsrceen">
	<div class="videoWrapper padding_top_10">
		<div class="videoContent">
			<div class="vcontainer">
<style>
.MacPlayer {background: #000000;font-size: 14px;color: #F6F6F6;margin: 0px;padding: 0px;position: relative;overflow: hidden;width: 100%;height: 100%;min-height: 100px;}
.MacPlayer table {width: 100%;height: 100%;}
.MacPlayer #playleft {position: inherit; ! important;width: 100%;height: 100%;}
</style>
				<div class="MacPlayer" id="MacPlayerBox"></div>
				<script src="/static/js/DPlayer.min.js"></script>
				<script type="text/javascript">
    					const dp = new DPlayer({
    					    container: document.getElementById('MacPlayerBox'),
    					    
    					    logo: '/static/images/logo.png',
    					    volume: 0.7,
    					    mutex: true,
    					    video: {
    					        url: "<?=$this->context->res_video . $video['video_url']?>",
    					        pic: "<?=$this->context->res_image . $video['images']?>"
    					        
    					    },
    					});
			   </script>
			</div>
			<div class="video-action">
				<a onclick="sc()"
					class="collect_dovideo video-action-btn heart md-opjjpmhoiojifppkkcdabiobhakljdgm_doc">
					<i class="glyphicon glyphicon-heart"
					style="color: rgb(255, 255, 255);"></i> <span class="text">影片收藏</span>
				</a>
				<div class="like-number">
					<div>
						<span class="number mac_hits hits" style="line-height: 20px;"
							data-mid="1" data-id="<?=$video['id']?>" data-type="hits"><?=$video['up_num']?></span>
					</div>
				</div>
				<div class="videoviews">
					<i class="glyphicon glyphicon-eye-open"></i> <span>瀏覽數：</span> <span
						class="number mac_hits hits" style="line-height: 20px;"
						data-mid="1" data-id="<?=$video['id']?>" data-type="hits"><?=$video['hit_num']?></span>
				</div>
				<div class="videoOtherInfo">
					<div class="text-view">
						<i class="glyphicon glyphicon-eye-open"></i> <span>瀏覽數：</span> <span
							class="number mac_hits hits" style="line-height: 20px;"
							data-mid="1" data-id="<?=$video['id']?>" data-type="hits"><?=$video['hit_num']?></span>
					</div>
					<div class="text-goodreview">
						<i class="glyphicon glyphicon-list-alt"></i> <span>最佳瀏覽環境</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<section class="sectionContent below_path_content">
	<div id="videoInfo" class="videoInfo">
		<div class="leftBox">
			<h1 class="video-title"><?=$video['title']?></h1>
			<div class="video-detail">
				<p class="list-item">
					<span>上傳時間：</span><span><?=$video['create_time']?></span>
				</p>
			</div>
		</div>
	</div>
	<div id="recommend" class="videoGroup">
		<div class="section-title grayBorder">
			<h2>或許您會喜歡</h2>
		</div>
		<div class="video-wrapper">
			<div id="comLoader" class="loader" style="display: none;">
				<div class="loader-inner ball-beat">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
			<?php foreach($lists as $item):?>
			<div class="col-style d-4 m-2 lazy loaded">
				<a href="/detail_<?=$item['id']?>.html"
					
					class="videoBox md-opjjpmhoiojifppkkcdabiobhakljdgm_doc">
					<div class="videoBox_wrap">
						<div class="videoBox-cover"
							style="background-image: url('<?=$this->context->res_image . $item['images']?>');"></div>
					</div>
					<div class="videoBox-info">
						<span class="title"><?=$item['title']?></span>
					</div>
					<div class="videoBox-action">
						<span class="views"><i class="fa fa-eye"></i><span class="number"
							style="line-height: 20px;"><?=$item['hit_num']?></span></span> <span
							class="likes"><i class="fa fa-heart"></i><span class="number"
							style="line-height: 20px;"><?=$item['up_num']?> </span></span>
					</div>
				</a>
			</div>
			<?php endforeach;?>
	</div>
</section>