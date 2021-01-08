<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
           
           <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label" style="width:70px; ">用户id</label>
                        <div class="layui-input-block">
                            <input type="text" "  name="UID" placeholder="请输入UID" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                       <?=$select_html?>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="data_search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>
           
            <table id="data_list" lay-filter="data_list"></table>
            <script type="text/html" id="data_control">
                {{#  if(d.type == '1'){ }}
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">审核</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">拒绝</a>
                {{#  } else { }}       
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">查看</a>         
                {{#  } }}
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
            , url: '/bank/income?data=1'
            , cols: [[
                  {field: 'id', title: 'ID',align:'left'}
                , {field: 'user_id', title: '用户id',align:'center'}
                , {field: 'username', title: '用户名',align:'center'}
                , {field: 'pay_name', title: '汇款人',align:'left'}
                , {field: 'bank_name', title: '银行名称',align:'left'}
                , {field: 'bank_card', title: '卡号',align:'center'}
                , {field: 'bank_account', title: '收款人',align:'center'}
                , {field: 'amount', title: '汇款金额',align:'center'}
                , {field: 'true_amount', title: '到账金额',align:'center'}
                , {field: 'type_title', title: '状态',align:'center'}
                , {field: 'create_date', title: '创建时间',align:'center'}
                , {title: '操作', align: 'center', fixed: 'right', toolbar: '#data_control',width:"14%"}
            ]]
            , page: true
            , limit: 20
            , height: 'full-180'
        });

        //监听工具条
        table.on('tool(data_list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
            	layer.confirm('您确定拒绝当前入款信息？', function (index) {
            		admin.req({
                        type: 'post',
                        url: '/bank/income-del?id='+data.id,
                        dataType: 'json',
                        data: {id: data.id},
                        success: function (res) {
                            if (res.code == '0') {
                                layer.msg('操作成功', {icon: 1}, function () {
                                    //obj.del();
                                    table.reload('data_list');
                                    //layer.close(index);
                                });
                            } else {
                                layer.msg('操作失败', {icon: 2});
                            }
                        }
                    });
                
            	});
            }else if (obj.event === 'edit') {  //点击列表事件edit
                layer.open({
                    type: 2
                    , title: '审核入款信息'
                    , content: '/bank/income-view?id=' + data.id
                    , maxmin: true
                    , area: ['650px', '600px']
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

        $('.layui-btn.layuiadmin-btn-list').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        
       
    });
</script>

