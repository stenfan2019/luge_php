<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-list" data-type="add">添加支付渠道</button>
            </div>
            <table id="data_list" lay-filter="data_list"></table>
            <script type="text/html" id="data_control">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
            </script>
        </div>
    </div>
</div>

<script>
    layui.use(['index', 'table', 'admin'], function () {
        var $ = layui.$
            , form = layui.form
            , admin = layui.admin
            , table = layui.table;

        //管理员管理
        table.render({
            elem: '#data_list'
            , url: '/payment/list?data=1'
            , cols: [[
                  {field: 'id', title: 'ID',align:'left'}
                , {field: 'title', title: '名称',align:'left'}
                , {field: 'merchant', title: '商户名称',align:'left'}
                , {field: 'type_title', title: '金额类型',align:'left'}
                , {field: 'is_show_title', title: '是否展示',align:'left'}
                , {field: 'pid_title', title: '分类',align:'left'}
                , {field: 'money_str', title: '固定金额',align:'center'}
                , {field: 'code', title: '代码编号',align:'center'}
                , {field: 'sort', title: '排序',align:'center'}
                , {field: 'create_date', title: '创建时间',align:'center'}
                , {title: '操作', align: 'center', fixed: 'right', toolbar: '#data_control',width:"8%"}
            ]]
            , page: true
            , limit: 20
            , height: 'full-180'
        });

      //监听工具条
        table.on('tool(data_list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
            	layer.confirm('确定删除此内容？', function (index) {
                    admin.req({
                        type: 'post',
                        url: '/payment/del?id='+ data.id,
                        dataType: 'json',
                        data: {id: data.id},
                        success: function (res) {
                            if (res.code == '0') {
                                layer.msg('删除成功', {icon: 1}, function () {
                                    //obj.del();
                                    table.reload('data_list');
                                    //layer.close(index);
                                });
                            } else {
                                layer.msg('添加失败', {icon: 2});
                            }
                        }
                    });
            	});
            } else if (obj.event === 'edit') {  //点击列表事件edit
                layer.open({
                    type: 2
                    , title: '修改信息'
                    , content: '/payment/edit?id=' + data.id
                    , maxmin: true
                    , area: ['700px', '600px']
                    , btn: ['确定', '取消']
                    , yes: function (index, layero) {
                        var iframeWindow = window['layui-layer-iframe' + index]
                            , submit = layero.find('iframe').contents().find("#form_submit");    //子框中的提交按钮
                        //子框提交
                        submit.trigger('click');
                    }
                });
            } 
        });

        table.on('sort(data_list)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            //尽管我们的 table 自带排序功能，但并没有请求服务端。
            //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
            table.reload('data_list', {
                initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。 layui 2.1.1 新增参数
                , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                    field: obj.field //排序字段
                    , order: obj.type //排序方式
                }
            });
        });

       

        var $ = layui.$, active = {
            add: function () {
                layer.open({
                    type: 2, 
                    title: '添加支付渠道', 
                    content: '/payment/add', 
                    maxmin: true, 
                    area: ['700px', '600px'], 
                    btn: ['确定', '取消'], 
                    yes: function (index, layero) {
                        var submit = layero.find('iframe').contents().find("#form_submit");
                        submit.click();
                    }
                });
            }
        };

        $('.layui-btn.layuiadmin-btn-list').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        
       
    });
</script>