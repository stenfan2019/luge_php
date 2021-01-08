<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-inline">
                <input type="text" name="mobile" readonly="readonly" lay-verify="required" value="<?=$item['mobile']?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        
    </div>
    
   <div class="layui-form-item more_option">
        <label class="layui-form-label">昵称</label>
        <div class="layui-input-inline">
            <input type="text" name=nick_name value="<?=$item['nick_name']?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    
    <div class="layui-form-item more_option">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-inline">
            <input type="text" name="password" placeholder="请输入昵称" autocomplete="off" class="layui-input">
        </div>
    </div>
    
    <div class="layui-form-item more_option">
        <label class="layui-form-label">账号金额</label>
        <div class="layui-input-inline">
            <input type="text" readonly="readonly" name="amount" value="<?=$item['amount']?>" class="layui-input">
        </div>
    </div>
    
     <div class="layui-form-item more_option">
        <label class="layui-form-label">变动金额</label>
        <div class="layui-input-inline">
            <input type="text" maxlength="7"  name="change_amount"  class="layui-input"><font color="red">减钱负数[单位:元]</font>
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
                url: '/user/edit?id=<?=$item["uid"]?>',
                dataType: 'json',
                data: field,
                success: function (res) {
                    if (res.code == '0') {
                        layer.msg('编辑成功', {icon: 1}, function () {  //提示完后,才执行里面的
                            parent.location.reload();
                            parent.layer.close(index);
                        });
                    } else {
                        layer.msg('编辑失败', {icon: 2});
                    }
                }
            });
        });

    })
</script>