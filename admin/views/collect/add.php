<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">开户人</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required"  autocomplete="off" class="layui-input">
                
            </div>
            <?=$bank_html?>
        </div>
        
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">银行卡号</label>
        <div class="layui-input-block">
             <input type="text" name="card" lay-verify="required" maxlength="19" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">分行地址</label>
        <div class="layui-input-block">
             <input type="text" name="address" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
    </div>
   <div class="layui-form-item">
        <label class="layui-form-label">总存款</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="limit_max"  maxlength="8" lay-verify="required"  autocomplete="off"
                   class="layui-input">
        </div>
        
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">单日最大</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="limit_day_max"  maxlength="8" lay-verify="required"  autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">单笔最小</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="limit_once_min" value="0"  maxlength="8" lay-verify="required"  autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">单笔最大</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="limit_once_max"  maxlength="8" lay-verify="required"  autocomplete="off"
                   class="layui-input">
        </div>
    </div>
   
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sort" value="99" maxlength="5" lay-verify="required" placeholder="请输入排序值,0最前" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">排序值,1~999,1最前</div>
    </div>
    <div class="layui-form-item more_option">
        <label class="layui-form-label">存款说明</label>
        <div class="layui-input-block">
          <textarea name="memo" placeholder="请输入内容" class="layui-textarea"></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="form_submit" id="form_submit" value="确认添加">
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
                url: '/collect/add',
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

        upload.render({
            elem: '#test3'
            , url: '<?=$up_data['api_url']?>'
            ,headers: { "Authorization": "<?=$up_data['strToken']?>" }
            , accept: 'file' //普通文件
            , done: function (res) {
                $('#show_pic').val(res.data.path)
                console.log(res)
            }
        });

       

    })
</script>