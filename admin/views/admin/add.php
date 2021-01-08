<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-inline">
                <input type="text" name="username" lay-verify="required" onkeyup="this.value=this.value.replace(/[^\w_]/g,'')" placeholder="请输入账号" autocomplete="off" class="layui-input">
            </div>
        </div>
        
    </div>
    <div class="layui-form-item more_option">
        <label class="layui-form-label">手机号</label>
        <div class="layui-input-inline">
            <input type="number" name="mobile" placeholder="请输入手机" autocomplete="off" class="layui-input">
        </div>
    </div>
   <div class="layui-form-item more_option">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-inline">
            <input type="text" name="true_name" placeholder="请输入名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    
    <div class="layui-form-item more_option">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-inline">
            <input type="text" name="password" placeholder="请输入昵称" onkeyup="this.value=this.value.replace(/[^\w_]/g,'')"  autocomplete="off" class="layui-input">
        </div>
    </div>

    
    <div class="layui-form-item more_option">
        <label class="layui-form-label">权限</label>
        <div class="layui-input-inline">
            <?=\common\helpers\Html::dropDownList('role_id','role_id',$roles);
            ?>
        </div>
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
                url: '/admin/add',
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