<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">银行名称</label>
            <div class="layui-input-inline">
                <input type="text" name="bank_name" readonly="readonly" value="<?=$item['bank_name']?>"  class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">银行卡号</label>
        <div class="layui-input-block">
             <input type="text" name="bank_card" readonly="readonly" value="<?=$item['bank_card']?>"  class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">付款人</label>
        <div class="layui-input-block">
             <input type="text" name="pay_name" readonly="readonly" value="<?=$item['pay_name']?>"  class="layui-input">
        </div>
    </div>
    

    <div class="layui-form-item">
        <label class="layui-form-label">转账金额</label>
        <div class="layui-input-block">
             <input type="text" name="amount" readonly="readonly" value="<?=sprintf("%.2f",$item['amount'] / 100)?>"  class="layui-input">
            
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">实际金额</label>
        <div class="layui-input-block">
             <input type="text" name="true_amount" value="<?=sprintf("%.2f",$item['true_amount'] / 100)?>" class="layui-input" >
            
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">审核说明</label>
        <div class="layui-input-block">
             <textarea name="memo" placeholder="请输入内容" class="layui-textarea"><?=$item['memo']?></textarea>
        </div>
    </div>
    
    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="form_submit" id="form_submit" value="确认编辑">
        <!--<input type="button" lay-submit lay-filter="form_edit" id="form_edit" value="确认编辑">-->
    </div>
</div>

<script>
    layui.use(['index', 'form', 'admin','upload'], function () {
        var $ = layui.$
            , form = layui.form
            , admin = layui.admin
            , upload = layui.upload;

        //监听提交
        form.on('submit(form_submit)', function (data) {
            var field = data.field; //获取提交的字段
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引

            //提交 Ajax 成功后，关闭当前弹层并重载表格
            //与 $ajax 一样,只是多了异常捕捉
            admin.req({
                type: 'post',
                url: '/bank/income-view?id=<?=$item['id']?>',
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