<div class="layui-form" lay-filter="action_form" id="action_form" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" placeholder="请输入标题" value="<?=$item['name']?>" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">类型</label>
            <div class="layui-input-block">
                <select>
                    <option value="<?=$item['type']?>"><?=\common\models\ActiveType::getTypeName($item['type'])?></option>
                </select>
            </div>
        </div>
    </div>


    <div class="layui-form-item" id="condition">
        <object id="content">
            <?php foreach ($condition[\common\models\ActiveType::CONDITION_MONEY] as $ite => $v){ ?>
            <?php foreach ($allCondition['condition'] as $key => $val){ ?>
                <div class="layui-inline">
                    <label class="layui-form-label"><?=$val['name']?></label>
                    <div class="layui-input-inline" style="width:120px">
                        <input type="text" name="condition[<?=$key?>][]" value="<?=$condition[$key][$ite]?>" placeholder="请输入<?=$val['name']?>" autocomplete="off" class="layui-input" style ="width:120px">
                    </div>
                </div>
            <?php } ?>
            <div class="layui-inline">
                <label class="layui-form-label" style ="width:30px">奖励</label>
                <div class="layui-input-inline" style ="width:80px">
                    <select name="bonus[name][]" val="<?=$bonus['name'][$ite]?>">
                        <?=$select_bonus?>
                    </select>
                </div>
                <div class="layui-input-inline" style="width:90px">
                    <input type="text" name="bonus[value][]" value="<?=$bonus['value'][$ite]?>" placeholder="请输入数字" autocomplete="off" class="layui-input" style ="width:90px">
                </div>
            </div>
            <?php } ?>
        </object>
        <button onclick="add_con(this)" type="button" class="layui-btn" style ="width:80px">添加<i class="layui-icon"></i></button>

    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">web图片</label>
        <div class="layui-input-block">
            <input type="text" id="web_pic" name="web_pic" lay-verify="required" placeholder="请输入" value="<?=$item['web_pic']?>" autocomplete="off" class="layui-input">
            <button type="button" class="layui-btn" id="webpic"><i class="layui-icon"></i>上传文件</button>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">pc图片</label>
        <div class="layui-input-block">
            <input type="text" id="pc_pic" name="pc_pic" lay-verify="required" placeholder="请输入" value="<?=$item['pc_pic']?>" autocomplete="off" class="layui-input">
            <button type="button" class="layui-btn" id="pcpic"><i class="layui-icon"></i>上传文件</button>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block">
            <textarea class="layui-textarea" id="descript" name="descript" style="display: none;"><?=$item['descript']?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开始时间</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="start_time" name="start_time" value="<?=$item['start_time']?>" placeholder="选择开始时间">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">截至时间</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="end_time" name="end_time" value="<?=$item['end_time']?>" placeholder="选择截止时间">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">领取方式</label>
        <div class="layui-input-inline">
            <select name="get_type" val="<?=$item['get_type']?>">
                <?=$get_type?>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否显示</label>
        <div class="layui-input-inline">
            <select name="status" value="<?=$item['status']?>">
            <?=$get_status?>
            </select>
        </div>
    </div>

    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="form_submit" id="form_submit" value="确认添加">
        <!--<input type="button" lay-submit lay-filter="form_edit" id="form_edit" value="确认编辑">-->
    </div>
</div>

<script>
    layui.use(['index', 'form', 'admin','upload','layedit'], function () {
        var $ = layui.$
            , form = layui.form
            , admin = layui.admin
            , upload = layui.upload
            , layedit = layui.layedit;

        //编辑器
        layedit.set({
            uploadImage: {
                url: '/upload/img-editor' //接口url
                ,type: 'post' //默认post
            }
        });
        var content = layedit.build('descript'); //建立编辑器

        //给所有select动态赋值
        var select = $("select");
        for(var i=0;i<=select.length;i++)
        {
            select.eq(i).find("option[value="+select.eq(i).attr("val")+"]").prop("selected",true);
        }

        layui.form.render();
        //监听提交
        form.on('submit(form_submit)', function (data) {
            var field = data.field; //获取提交的字段
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引

            //提交 Ajax 成功后，关闭当前弹层并重载表格
            //与 $ajax 一样,只是多了异常捕捉
            admin.req({
                type: 'post',
                url: 'edit?id=<?=$item['id']?>',
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

        upload.render({
            elem: '#webpic'
            , url: '/upload/img'
            , accept: 'file' //普通文件
            , done: function (res) {
                $('#web_pic').val(res.data.path)
                console.log(res)
            }
        });

        upload.render({
            elem: '#pcpic'
            , url: '/upload/img'
            , accept: 'file' //普通文件
            , done: function (res) {
                $('#pc_pic').val(res.data.path)
                console.log(res)
            }
        });
    });

    layui.use('layedit', function(){
        var layedit = layui.layedit;
        layedit.set({
            uploadImage: {
                url: '/upload/img-editor' //接口url
                ,type: 'post' //默认post
            }
        });
        layedit.build('descript'); //建立编辑器
    });
    layui.use('laydate', function() {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#start_time'
            ,type: 'datetime'
            ,trigger: 'click'
            // ,range: '到'
            ,format: 'yyyy-M-d H:m:s'
        });

        laydate.render({
            elem: '#end_time'
            ,type: 'datetime'
            ,trigger: 'click'
            // ,range: '到'
            ,format: 'yyyy-M-d H:m:s'
        });
    });
    function add_con(obj){
        var htmls = $("#content").html();
        $(obj).remove();
        htmls += '<button onclick="add_con(this)" type="button" class="layui-btn" style ="width:60px">添加<i class="layui-icon"></i></button>';
        $("#condition").append(htmls);
        layui.use(['form'], function () {
            var form = layui.form;
            layui.form.render('select');
        });
    };
</script>