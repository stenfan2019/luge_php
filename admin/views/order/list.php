<div class="layui-fluid">
    <div class="layui-card">
       <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:70px; ">用户id</label>
                    <div class="layui-input-block">
                        <input type="text"  name="uid" placeholder="请输入UID" autocomplete="off" class="layui-input">
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
        <div class="layui-card-body">
            
            <table id="data_list" lay-filter="data_list"></table>
            <script type="text/html" id="data_control">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="view"><i class="layui-icon layui-icon-edit"></i>编辑</a>
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
            , url: '/order/list?data=1'
            , cols: [[
                      {field: 'order_id',width:'7%', title: '订单id',align:'left'}
                    , {field: 'order_sn',width:'14%', title: '订单编号',align:'left'}
                    , {field: 'uid',width:'8%', title: 'UID',align:'left'}
                    , {field: 'username',width:'12%', title: '用户昵称',align:'center'}
                    , {field: 'pay_channel_name',width:'9%', title: '支付通道',align:'center'}
                    , {field: 'amount',width:'7%', title: '订单金额',align:'center'}
                    , {field: 'ip', width:'9%',title: 'ip',align:'center'}
                    , {field: 'pay_status_title',width:'7%', title: '状态',align:'center'}
                    , {field: 'create_time',width:'12%', title: '交易时间',align:'center'}
                    , {field: 'notify_ip', width:'9%',title: '通知ip',align:'center'}
                    , {field: 'return_amount',width:'7%', title: '返回金额',align:'center'}
                    , {field: 'notify_time',width:'12%', title: '通知时间',align:'center'}
                    , {title: '操作', align: 'center', fixed: 'right', toolbar: '#data_control',width:"7%"}
            ]]
            , page: true
            , limit: 20
            , height: 'full-180'
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

        //
        table.on('tool(data_list)', function (obj) {
        	var data = obj.data;
        	if (obj.event === 'view') {
           		layer.open({
                     type: 2
                     , title: '修改信息'
                     , content: '/order/edit?id=' + data.order_id
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
        //监听搜索
        form.on('submit(data_search)', function (data) {
             var field = data.field;
             //执行重载
             table.reload('data_list', {
                 where: field
             });
         });
       
    });
</script>

