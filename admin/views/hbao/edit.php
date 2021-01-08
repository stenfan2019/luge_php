<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">房间名称</label>
        <div class="layui-input-block">
             <input type="text" name="name" value="<?=$item['name']?>" lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>
   <div class="layui-form-item" >
       <div class="layui-inline">
          <label class="layui-form-label">范围金额</label>
             <div class="layui-input-inline" style="width: 100px;">
                <input type="text" value="<?=$item['start_money']?>" name="start_money" placeholder="￥" autocomplete="off" class="layui-input">
             </div>
             <div class="layui-form-mid">-</div>
             <div class="layui-input-inline" style="width: 100px;">
                <input type="text" value="<?=$item['end_money']?>" name="end_money" placeholder="￥" autocomplete="off" class="layui-input">
             </div>
       </div>
    </div>
    
    <div class="layui-form-item more_option">
        <div class="layui-inline">
            <label class="layui-form-label">红包生命期</label>
            <div class="layui-input-inline">
                <input type="text" name="life_time" value="<?=$item['life_time']?>" lay-verify="required|number"  autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">是否展示</label>
            <?=$show_on?>
        </div>
    </div>

    <div class="layui-form-item more_option">
        <div class="layui-inline">
            <label class="layui-form-label">房间杀率</label>
            <div class="layui-input-inline">
                <input type="text" name="odds" value="<?=$item['odds']?>" lay-verify="required|number" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
               <input type="text" name="sort" value="<?=$item['sort']?>" lay-verify="required|number" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>
    
    <div class="layui-form-item more_option">
        <div class="layui-inline">
            <label class="layui-form-label">机器人数</label>
            <div class="layui-input-inline">
                <input type="text" name="robet_num" value="<?=$item['robet_num']?>" lay-verify="required|number" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-form-item more_option">
        <div class="layui-inline">
            <label class="layui-form-label">机发杀率</label>
            <div class="layui-input-inline">
                <input type="text" value="<?=$item['robet_send_odds']?>" name="robet_send_odds" lay-verify="required|number" placeholder="机器人发红包出雷的概率" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">机抢杀率</label>
            <div class="layui-input-inline">
               <input type="text" value="<?=$item['robet_rob_odds']?>" name="robet_rob_odds" lay-verify="required|number" placeholder="机器人抢包避开雷的概率" class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
       <label class="layui-form-label">机器人</label>
       <div class="layui-input-block">
             <textarea name="robet_ids" placeholder="机器人id多个用,隔开" class="layui-textarea"><?=$item['robet_ids']?></textarea>
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
                url: '/hbao/edit?id=<?=$item['id']?>',
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