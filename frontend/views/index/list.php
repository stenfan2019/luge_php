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
							style="background-image: url('<?= $this->context->res_image . $video['images']?>');"></div>
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
<script>
	var loading = false;
	$(window).scroll(function(){
		if(!loading && $(window).scrollTop()+$(window).height()>=$(document).height() - 250)
		{	
			loading = true;
			ajaxRead();
		}
	});
	
	var page=3;//初始页数
	var mid=1;//mid:模块1视频2文章3专题        
	var limit=20;//每页条数，支持10,20,30 
	var order="";//当前order排序
	var by= "vod_time";//当前排序方式
	var wd= "";//标题关键词
	var tag= "";//tag标签
	function ajaxRead(){
		var html='' ;
        $.ajax({
			url : "/index/data-page?page="+page,
			type:'GET',
            dataType:"html",
            success : function(html){
               //alert(html);
               if(html){
                    var vod_list=$('#app');
					vod_list.append(html);
					page +=1
               }else{
					$('#loadmore').show().html("已全部加載完畢！");
				};
				
				
				loading = false;
			},
			error:function(){
				alert("请求失败");
			}	
        });
	}
  </script>

