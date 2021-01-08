<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">角色代码</label>
            <div class="layui-input-inline">
                <input type="text" name="role" lay-verify="required" onkeyup="this.value=this.value.replace(/[^\w_]/g,'')" placeholder="请输入账号" autocomplete="off" class="layui-input">
            </div>
        </div>
        
    </div>
    <div class="layui-form-item more_option">
        <label class="layui-form-label">角色名称</label>
        <div class="layui-input-inline">
            <input type="text" name="name" placeholder="请输入角色额名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <label class="layui-form-label">操作权限</label>
    <div class="layui-form-item more_option" style="margin-left: 10%"  >
            <?php
            foreach ($allMenu as $k => $menu)
            {
                echo '<div class="layui-input-inline">';
//                echo \common\helpers\Html::checkbox('name[]', 'title', ['title'=>$menu['title']]);
                echo \common\helpers\Html::tag('h2',$menu['title']);
                echo '</div>';
                echo "<hr>";
                echo "<div style='margin-right: 10%'>";
                foreach ($menu['_child'] as $kk => $m)
                {
                    echo \common\helpers\Html::checkbox('powers['.$menu['id'].']['.$m['id'].']','',['value'=>$m['url'],'title'=>$m['title']]);

                }
                echo "</div>";
                echo "<hr />";
            }

            ?>
        </div>


        <!--<div class="layui-form-item">
        <label class="layui-form-label">查看权限</label>
        <div class="layui-form-item more_option" style="margin-left: 10%"  >
            <?php
/*            foreach ($allMenu as $k => $menu)
            {
                echo '<div class="layui-input-inline">';
//                echo \common\helpers\Html::checkbox('name[]', 'title', ['title'=>$menu['title']]);
                echo \common\helpers\Html::tag('h2',$menu['title']);
                echo '</div>';
                echo "<hr>";
                echo "<div style='margin-right: 10%'>";
                foreach ($menu['_child'] as $kk => $m)
                {
                    echo \common\helpers\Html::checkbox('menu_powers['.$menu['id'].']['.$m['id'].']','',['value'=>$m['url'],'title'=>$m['title']]);

                }
                echo "</div>";
                echo "<hr />";
            }

            */?>
        </div>
        </div>-->


    
    
    
    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="form_submit" id="form_submit" value="确认添加">
        <!--<input type="button" lay-submit lay-filter="form_edit" id="form_edit" value="确认编辑">-->
    </div>
</div>

<script>
    layui.use(['index', 'form', 'admin'], function () {
        var $ = layui.$
            , form = layui.form
            , admin = layui.admin;

        //监听提交
        form.on('submit(form_submit)', function (data) {
            var field = data.field; //获取提交的字段
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引

            //提交 Ajax 成功后，关闭当前弹层并重载表格
            //与 $ajax 一样,只是多了异常捕捉
            admin.req({
                type: 'post',
                url: '/admin-role/add',
                dataType: 'json',
                data: field,
                success: function (res) {
                    if (res.code == '0') {
                        layer.msg('添加成功', {icon: 1}, function () {  //提示完后,才执行里面的
                            parent.location.reload();
                            parent.layer.close(index);
                        });
                    } else {
                        layer.msg('添加失败', {icon: 2});
                    }
                }
            });
        });

    })
</script>