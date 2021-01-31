		<section class="sectionContent">
		    <?php if($lists_16):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						免費試看<small>（不用註冊限時體驗）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="#" class="btn btn-info">
						<i class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="http://fhty1760.com"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap" style="padding-bottom:80%">
								<div class="videoBox-cover"
									style="background-image: url('/static/images/tg01.png');"></div>
								 <span class="video-tag free">广告</span>
							</div>
							
						</a>
					</div>
					<?php foreach($lists_16 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">免費</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="http://fhty1760.com"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap" style="padding-bottom:80%">
								<div class="videoBox-cover"
									style="background-image: url('/static/images/tg02.png');"></div>
								<span class="video-tag free">广告</span>
							</div>
							
						</a>
					</div>
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_02):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						精選系列<small>（精挑細選強烈推薦）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="/jingxuan.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_02 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
					
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_01):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						中文字幕<small>（聽不懂日語沒關系）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="/zwzm.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_01 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_03):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						亞洲無碼<small>（想看哪裏就看哪裏）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="/yzwm.htmlv" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_03 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_04):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						亞洲有碼<small>（日本片厂同步更新）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="/yzym.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_04 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
			<?php if($lists_05):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						無碼破解<small>（去掉煩人的馬賽克）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="/wmpj.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_05 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_06):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>偷拍自拍</h2>
					<div class="cat_select_wrap">
						<a href="/tpzp.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_06 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_07):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						網紅<small>（抖音快手斗魚花椒）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="/wanghong.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_07 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
					
				</div>
			</div>
			<?php endif;?>
            <?php if($lists_08):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>主播</h2>
					<div class="cat_select_wrap">
						<a href="/zhubo.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_08 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_12):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>
						明星<small>（AI換臉下海明星）</small>
					</h2>
					<div class="cat_select_wrap">
						<a href="/star.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_12 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
            <?php if($lists_13):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>三級</h2>
					<div class="cat_select_wrap">
						<a href="/sanji.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_13 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
					
				</div>
			</div>
			<?php endif;?>
            <?php if($lists_14):?>
			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>歐美</h2>
					<div class="cat_select_wrap">
						<a href="/oumei.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_14 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
			<?php endif;?>
            <?php if($lists_15):?>

			<div class="videoGroup">
				<div class="section-title grayBorder">
					<h2>動漫</h2>
					<div class="cat_select_wrap">
						<a href="/dongman.html" class="btn btn-info"><i
							class="fa fa-refresh fa-spin"></i> 看更多</a>
					</div>
				</div>
				<div class="video-wrapper index_M">
					<div id="freeLoader" class="loader" style="display: none;">
						<div class="loader-inner ball-beat">
							无法加载？
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<?php foreach($lists_15 as $video):?>
					<div class="col-style d-4 m-2 lazy loaded">
						<a href="/detail_<?=$video['id']?>.html"
							target="_blank" class="videoBox">
							<div class="videoBox_wrap">
								<div class="videoBox-cover"
									style="background-image: url('<?=$video['images']?>');"></div>
								<span class="video-tag free">VIP</span>
							</div>
							<div class="videoBox-info">
								<span class="title"><?=$video['title']?></span>
							</div>
							<div class="videoBox-action">
								<span class="views"><i class="fa fa-eye"></i><span
									class="number"><?=$video['hit_num']?></span></span> <span class="likes"><i
									class="fa fa-heart"></i><span class="number"><?=$video['up_num']?></span></span>
							</div>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
            <?php endif;?>
            
			
		</section>