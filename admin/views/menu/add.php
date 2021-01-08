<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-inline">
                <input type="text" name="title" value="" lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">上级菜单</label>
            <?=$html_select?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">类型</label>
        <?=$html_radio?>
    </div>

    <div class="layui-form-item more_option">
        <div class="layui-inline">
            <label class="layui-form-label">控制器</label>
            <div class="layui-input-inline">
                <input type="text" id="controller" name="controller" lay-verify="required" placeholder="请输入指向控制器" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">方法</label>
            <div class="layui-input-inline">
                <input type="text" id="action" name="action" lay-verify="required" placeholder="请输入指向方法" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-form-item more_option">
        <label class="layui-form-label">附加参数</label>
        <div class="layui-input-inline">
            <input type="text" name="param" placeholder="添加路径参数,如有" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">图标</label>
        <div class="layui-input-inline">
            <input type="text" name="icon" placeholder="layui图标代码" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"><a href="https://www.layui.com/doc/element/icon.html" target="_blank">点击查看</a> </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sort" value="10" maxlength="5" lay-verify="required" placeholder="请输入排序值,0最前" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">排序值,0~999,0最前</div>
    </div>
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
                url: '/menu/add',
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

        form.on('radio(radio_type_0)', function (data) {
            $(".more_option").hide();
            $("#controller").removeAttr("lay-verify");
            $("#action").removeAttr("lay-verify");
        });

        form.on('radio(radio_type_1)', function (data) {

            $("#controller").attr("lay-verify", "required");
            $("#action").attr("lay-verify", "required");
            $(".more_option").show();
        });

    })
</script>