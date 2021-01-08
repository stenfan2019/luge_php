<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn addAction" rel="0">添加</button>
            </div>
            <table class="layui-table" id="data_list" lay-filter="data_list">
                <thead>
                <tr>
                    <th class="text_center">ID</th>
                    <th>标题</th>
                    <th>类型</th>
                    <th>控制器</th>
                    <th>方法</th>
                    <th>URL</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $row):?>
                <tr>
                    <td align="center"><?=$row['id']?></td>
                    <td><?=$row['title']?></td>
                    <td align="center"><?=$row['type'] == 1 ? '权限菜单':'目录'?></td>
                    <td align="center"><?=$row['controller']?></td>
                    <td align="center"><?=$row['action']?></td>
                    <td align="center"><?php if($row['type']):?><a href="<?=$row['url']?>" target="_blank">URL</a><?php endif;?></td>
                    <td align="center">
                        <?php if($row['type'] == '0'):?>
                        <a class="layui-btn layuiadmin-btn-list layui-btn-normal layui-btn-xs addAction" rel="<?=$row['id']?>">
                            <i class="layui-icon layui-icon-edit"></i>添加子菜单
                        </a>
                       <?php endif;?>
                        <a class="layui-btn layuiadmin-btn-list layui-btn-normal layui-btn-xs editAction" rel="<?=$row['id']?>">
                            <i class="layui-icon layui-icon-edit"></i>编辑
                        </a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs delAction" data-type="del" rel="<?=$row['id']?>">
                            <i class="layui-icon layui-icon-delete"></i>删除</a>
                       </td>
                </tr>
                    <?php if(array_key_exists('child', $row)):?> 
                        <?php foreach($row['child'] as $row2):?>
                            <tr>
                                <td align="center"><?=$row2['id']?></td>
                                <td style="padding-left: 30px">> <?=$row2['title']?></td>
                                <td align="center"><?=$row2['type'] == 1 ? '权限菜单':'目录'?></td>
                                <td align="center"><?=$row2['controller']?></td>
                                <td align="center"><?=$row2['action']?></td>
                                <td align="center"><?php if($row2['type']):?><a href="<?=$row2['url']?>" target="_blank">URL</a><?php endif?></td>
                                <td align="center">
                                    <?php if($row2['type'] == '0'):?>
                                    <a class="layui-btn layuiadmin-btn-list layui-btn-normal layui-btn-xs addAction" rel="<?=$row2['id']?>"><i
                                            class="layui-icon layui-icon-edit"></i>添加子菜单
                                    </a>
                                    <?php endif;?>
                                    <a class="layui-btn layuiadmin-btn-list layui-btn-normal layui-btn-xs editAction" rel="<?=$row2['id']?>"><i
                                        class="layui-icon layui-icon-edit"></i>编辑</a>
                                    <a class="layui-btn layui-btn-danger layui-btn-xs delAction" data-type="del" rel="<?=$row2['id']?>"><i
                                            class="layui-icon layui-icon-delete"></i>删除</a></td>
                            </tr>
                           <?php if(array_key_exists('child', $row2)):?> 
                            <?php foreach($row2['child'] as $row3):?>
                            <tr>
                                <td align="center"><?=$row3['id']?></td>
                                <td style="padding-left: 50px">> {{row3['title']}}</td>
                                <td align="center"><?=$row3['type'] == 1 ? '权限菜单':'目录'?></td>
                                <td align="center"><?=$row3['controller']?></td>
                                <td align="center"><?=$row3['action']?></td>
                                <td align="center"><?php if($row3['type']):?><a href="<?=$row3['url']?>" target="_blank">URL</a><?php endif?></td>
                                <td align="center">
                                    <a class="layui-btn layuiadmin-btn-list layui-btn-normal layui-btn-xs editAction" rel="{{row3['id']}}"><i
                                        class="layui-icon layui-icon-edit"></i>编辑
                                    </a>
                                    <a class="layui-btn layui-btn-danger layui-btn-xs delAction" data-type="del" rel="{{row3['id']}}"><i
                                            class="layui-icon layui-icon-delete"></i>删除
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                          <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    layui.use(['index', 'table', 'admin'], function () {
        var table = layui.table
            , form = layui.form
            , $ = layui.jquery
            , admin = layui.admin;

        $(".delAction").click(function () {
            var id = $(this).attr("rel");
            layer.confirm('确定删除此信息？', function (index) {
                admin.req({
                    type: 'post',
                    url: '/menu/del?id='+id,
                    dataType: 'json',
                    data: {id: id},
                    success: function (res) {
                        if (res.code == '0') {
                            layer.msg('删除成功', {icon: 1}, function () {
                                location.reload();
                            });
                        } else {
                            layer.msg('添加失败', {icon: 2});
                        }
                    }
                });
                layer.close(index); //关闭弹层

            });
        });

        $(".addAction").click(function () {
            var pid = $(this).attr("rel");
            layer.open({
                type: 2
                , title: '添加菜单'
                , content: '/menu/add?pid=' + pid
                , maxmin: true
                , area: ['700px', '500px']
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#form_submit");
                    submit.click();
                }
            });
        });

        $(".editAction").click(function () {
            var id = $(this).attr("rel");
            layer.open({
                type: 2
                , title: '修改菜单'
                , content: '/menu/edit?id=' + id
                , maxmin: true
                , area: ['700px', '500px']
                , btn: ['确定', '取消']
                , yes: function (index, layero) {
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#form_submit");
                    submit.click();
                }
            });
        });


    });
</script>