<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
               <!-- <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="http://www.layui.com/admin/" target="_blank" title="前台">
                        <i class="layui-icon layui-icon-website"></i>
                    </a>
                </li>-->
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search"
                           layadmin-event="serach" lay-action="/search?keywords=">
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

                <li class="layui-nav-item" lay-unselect>
                    <a lay-href="/message/index" layadmin-event="message" lay-text="消息中心">
                        <i class="layui-icon layui-icon-notice"></i>
                        <!-- 如果有新消息，则显示小圆点 -->
                        <span class="layui-badge-dot"></span>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="note">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;">
                        <cite><?=$adminInfo['true_name']?></cite>
                    </a>
                    <dl class="layui-nav-child">
                        <!--<dd><a lay-href="set/user/info.html">基本资料</a></dd>-->
                        <dd><a lay-href="/admin/pwd">修改密码</a></dd>
                        <hr>
                        <dd style="text-align: center;"><a href="/login/logout">退出</a></dd>
                        <!--<dd layadmin-event="logout" style="text-align: center;"><a>退出</a></dd>-->
                    </dl>
                </li>

                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" ><i
                            class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" ><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
             <div class="layui-side layui-side-menu">
                <div class="layui-side-scroll">
                    <div class="layui-logo">
                        <span>总控管理系统</span>
                    </div>
            
                    <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu"
                        lay-filter="layadmin-system-side-menu">
            
            
                        <li data-name="home" class="layui-nav-item layui-nav-itemed">
                            <a href="javascript:;" lay-tips="主页" lay-direction="2">
                                <i class="layui-icon layui-icon-home"></i>
                                <cite>主页</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="layui-this">
                                    <a lay-href="/index/main">首页</a>
                                </dd>
                                <!--<dd>
                                    <a lay-href="/admin/common/upload">上传测试</a>
                                </dd>-->
                            </dl>
                        </li>
            
                        
                        <?php foreach ($menus as $menu):?>
                        <li data-name="set" class="layui-nav-item">
                            <a href="javascript:;" lay-tips="设置" lay-direction="2">
                                <i class="layui-icon <?=$menu['icon']?>"></i>
                                <cite><?=$menu['title']?></cite>
                            </a>
            
                            <?php  if(array_key_exists('child',$menu)): ?>
                                
                                 <?php foreach($menu['child'] as $pid=>$item): ?>
                                    <?php  if($item['type']): ?>
                                        <dl class="layui-nav-child">
                                            <dd><a lay-href="/<?=trim($item['url'],'/')?>"><?=$item['title']?></a></dd>
                                        </dl>
                                    
                                    <?php endif;?>
                               <?php endforeach; ?>
                            <?php endif?>
            
                        </li>
                       <?php endforeach?>
                    </ul>
                </div>
            </div>
            
            
            <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="/index/main" lay-attr="/index/main" class="layui-this"><i
                            class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="/index/main" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
