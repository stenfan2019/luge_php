<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">渠道名称</label>
            <div class="layui-input-inline">
                <input type="text" name="title" lay-verify="required" value="<?=$item["title"]?>" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">渠道编号</label>
            <div class="layui-input-inline">
                <input type="text" name="code" lay-verify="required" value="<?=$item["code"]?>" placeholder="由技术提供" autocomplete="off" class="layui-input">
            </div>
            
        </div>
    </div>
    
    <div class="layui-form-item">
        <label class="layui-form-label">商户名称</label>
        <div class="layui-input-block">
             <input type="text" name="merchant" value="<?=$item["merchant"]?>" lay-verify="required" placeholder="请输入商户名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属分类</label>
         <?=$cate_html?>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">金额类型</label>
         <?=$type_html?>
    </div>
    <div class="layui-form-item" id="guding_money" style="<?=2==$item['type'] ? '' : 'display:none;'?>">
        <label class="layui-form-label">固定金额</label>
        <div class="layui-input-block">
             <input type="text" name="money_str" value="<?=$item["money_str"]?>" placeholder="填写应许的固定金额，多个|分开" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item" id="range_money" style="<?=3==$item['type'] ? '' : 'display:none;'?>">
       <div class="layui-inline">
          <label class="layui-form-label">范围金额</label>
             <div class="layui-input-inline" style="width: 100px;">
                <input type="text" name="min_money" value="<?=$item["min_money"]?>" placeholder="￥" autocomplete="off" class="layui-input">
             </div>
             <div class="layui-form-mid">-</div>
             <div class="layui-input-inline" style="width: 100px;">
                <input type="text" name="max_money" value="<?=$item["max_money"]?>" placeholder="￥" autocomplete="off" class="layui-input">
             </div>
       </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sort" value="<?=$item["sort"]?>" maxlength="5" lay-verify="required" placeholder="请输入排序值,0最前" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">排序值,1~999,1最前</div>
    </div>
    <div class="layui-form-item"  >
        <label class="layui-form-label">提交网关</label>
        <div class="layui-input-block">
             <input type="text" name="gateway" value="<?=$item["gateway"]?>"  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商户号</label>
        <div class="layui-input-block">
             <input type="password" name="merchant_no" value="<?=$item["merchant_no"]?>"  autocomplete="off" class="layui-input">
        </div>
    </div>
    
    <div class="layui-form-item">
        <label class="layui-form-label">秘钥</label>
        <div class="layui-input-block">
             <input type="password" name="private_key" value="<?=$item["private_key"]?>"  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">公钥</label>
        <div class="layui-input-block">
             <input type="password" name="public_key" value="<?=$item["public_key"]?>"  autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否展示</label>
         <?=$is_show_html?>
    </div>
    <div class="layui-form-item layui-form-text">
       <label class="layui-form-label">其它参数</label>
       <div class="layui-input-block">
             <textarea name="more_str" placeholder="由技术提供" class="layui-textarea"><?=$item["more_str"]?></textarea>
       </div>
     </div>
    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="form_submit" id="form_submit" value="确认添加">
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
                url: '/payment/edit?id=<?=$item['id']?>',
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

        //特殊事件
        form.on('radio(radio_type_1)', function (data) {
            $("#guding_money").hide();
            $("#range_money").hide();
        });

        form.on('radio(radio_type_2)', function (data) {
        	$("#guding_money").show();
            $("#range_money").hide();
        });

        form.on('radio(radio_type_3)', function (data) {
       	    
            $("#guding_money").hide();
            $("#range_money").show();
        });
    })
</script>