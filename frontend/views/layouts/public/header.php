      <div class="header-container">
			<div class="logo_switch">
				<a href="/" class="header_link">
					<span class="header_logo cn">
						<img src="/static/images/logo_cn.png" width="100%">
					</span>
				</a>
			</div>
			<div class="website_switch">
				<a id="userLevelIconM" href="/member/favs"
					class="menusite_l" style="display: inline;"><span
					class="icon hd-member cn"></span></a>
			</div>
			<div class="searchbar_wrapper">
				<form method="get" name="search" action="/video/search">
					<input type="text" name="wd" placeholder="搜洞洞" required="required"
						class="search_bar" />
					<div class="search_btn">
						<button style="background: transparent;" type="submit">
							<i class="fa fa-search" style="line-height: 30px; color: #fff;"></i>
						</button>
					</div>
				</form>
			</div>
			<div class="searchkey_wrapper">
				<span>熱門&nbsp;:</span> 
				<a href="/video/search?wd=京香">京香</a> 
				<a href="/video/search?wd=波多野結衣">波多野結衣</a> 
				<a href="/video/search?wd=颜值">颜值</a> 
				<a href="/video/search?wd=制服">制服</a> 
			    <a href="/video/search?wd=巨乳">巨乳</a> 
			    <a href="/video/search?wd=口交">口交</a> 
			    <a href="/video/search?wd=SM">SM</a> 
				<a href="/video/search?wd=人妻">人妻</a>
			</div>
			<div class="phone_down" style="display: none">
				<a href="/home.html" class="down-button">
    				<span style="color: rgb(178, 58, 238);">
    				<i class="fa fa-download"></i>&nbsp;發布地址</span>
				</a>
			</div>
			<?php if(!$this->context->uid){?>
			<div id="userLoginIcon" class="login_menu jav_login">
                 <a id="jav_login" href="/login.html" class="login-button">
                 <span class="link">註冊 | 登錄</span></a>
            </div> 
            <?php }else{?>
			<div id="userLevelIcon" class="login_menu">
				<div class="member_group">
					<span class="user_profile"><span
						class="sprite sprite-icon-silver user_pic_wrapper"></span> <span
						class="user_id silver"><?=$this->context->nick_name?></span></span>
					<ul class="member_dropdown">
						<a href="/users" class="list_style" style="display:none"><li>會員中心</li></a>
						<a href="/member/favs" class="list_style"><li>我的收藏</li></a>
						<a href="/users/logout" class="list_style"><li>退出</li></a>
					</ul>
				</div>
			</div>
			<?php }?>
		</div>