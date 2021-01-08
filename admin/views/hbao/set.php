<div class="layui-fluid">
    <div class="layui-form" lay-filter="action_form" id="action_form">
        <div class="layui-card">
            <div class="layui-card-header">红包设置</div>
            <div class="layui-card-body" style="padding: 15px;">
                <div class="layui-form-item">
                    <label class="layui-form-label">单雷7包</label>
                    <div class="layui-input-block">
                        <input type="text" name="one7"  value="<?=$item['one7']?>" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">单雷9包</label>
                    <div class="layui-input-block">
                        <input type="text" name="one9"  value="<?=$item['one9']?>" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">双雷9包</label>
                    <div class="layui-input-block">
                        <input type="text" name="nine2"  value="<?=$item['nine2']?>" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">三雷9包</label>
                    <div class="layui-input-block">
                        <input type="text" name="nine3"  value="<?=$item['nine3']?>" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">四雷9包</label>
                    <div class="layui-input-block">
                        <input type="text" name="nine4"  value="<?=$item['nine4']?>" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">五雷9包</label>
                    <div class="layui-input-block">
                        <input type="text" name="nine5"  value="<?=$item['nine5']?>" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                


                <div class="layui-form-item layui-layout-admin">
                    <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="form_submit" id="form_submit">提交</button>
                    </div>
                </div>
            </div>
        </div>
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
                url: '/hbao/set',
                dataType: 'json',
                data: field,
                success: function (res) {
                    if (res.code == '0') {
                        layer.msg('success', {icon: 1}, function () {  //提示完后,才执行里面的
                            //parent.layui.table.reload('data_list'); //重载表格
                            parent.layer.close(index);              //再执行关闭
                        });
                    } else {
                        layer.msg('操作失败', {icon: 2});
                    }
                }
            });
        });
    })
</script>