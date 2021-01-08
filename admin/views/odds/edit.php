<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">彩种简称</label>
        <div class="layui-input-inline">
             <input type="text" name="lottery_code" value="<?=$item['lottery_code']?>" lay-verify="required" placeholder="请输入标题" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item more_option">
        <label class="layui-form-label">玩法</label>
        <div class="layui-input-inline">
            <input type="text" name="cate_name" value="<?=$item['cate_name']?>"  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item more_option">
        <label class="layui-form-label">投注结果</label>
        <div class="layui-input-inline">
            <input type="text" name="name" value="<?=$item['name']?>" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
        </div>
    </div>

    
    <div class="layui-form-item more_option">
        <label class="layui-form-label">赔率</label>
        <div class="layui-input-inline">
            <input type="text" name="odds" value="<?=$item['odds']?>" lay-verify="required|number"  autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item more_option">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="sort" value="<?=$item['sort']?>"  lay-verify="required|number" autocomplete="off" class="layui-input">
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
                url: '/odds/edit?id=<?=$item['id']?>',
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