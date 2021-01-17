<section class="sectionContent below_path_content">
	<div class="videoGroup">
		<div class="section-title grayBorder">
			<div>
				<h1><?=$sub_title?></h1>
			</div>
		</div>
		<div id="app" class="video-wrapper">
			<div id="comLoader" class="loader" style="display: none;">
				<div class="loader-inner ball-beat">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
			<?php foreach($videos as $video):?>
			<div class="col-style d-4 m-2 lazy loaded">
				<a href="/detail_<?=$video['id']?>.html"
					target="_blank"
					class="videoBox md-opjjpmhoiojifppkkcdabiobhakljdgm_doc">
					<div class="videoBox_wrap">
						<div class="videoBox-cover"
							style="background-image: url('<?=$video['images']?>');"></div>
					</div>
					<div class="videoBox-info">
						<span class="title"><?=$video['title']?></span>
					</div>
					<div class="videoBox-action">
						<span class="views"><i class="fa fa-eye"></i><span class="number"><?=$video['hit_num']?></span></span>
						<span class="likes"><i class="fa fa-heart"></i><span
							class="number"><?=$video['up_num']?></span></span>
					</div>
				</a>
			</div>
			<?php endforeach;?>
		</div>
		<div id="loadmore"
			style="color: #000; font-size: 16px; text-align: center; margin: 30px 0;"></div>
	</div>
</section>

