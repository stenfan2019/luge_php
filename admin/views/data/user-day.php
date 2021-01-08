<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:70px; ">账号</label>
                    <div class="layui-input-block">
                        <input type="text" name="uname" placeholder="请输入账号" autocomplete="off" class="layui-input">
                    </div>

                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:70px; ">日期</label>
                    <div class="layui-input-block">
                        <input type="text" name="date" id="date" placeholder="请选择日期" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="data_search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>

        </div>
            <table id="data_list" lay-filter="data_list"></table>
            <script type="text/html" id="data_control">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
            </script>
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
            , url: 'user-day?data=1'
            , cols: [[
                  // {field: 'id', title: 'ID',align:'left'},
                {field: 'uname', title: '会员账号',align:'center',width:'10%'}
                , {field: 'date', title: '日期',align:'center',width:'9%'}
                , {field: 'deposit_money', title: '充值金额',align:'center',width:'7%'}
                , {field: 'deposit_num', title: '充值次数',align:'center',width:'7%'}
                , {field: 'withdraw_success_money', title: '提现金额',align:'center',width:'7%'}
                , {field: 'withdraw_success_num', title: '提现次数',align:'center',width:'7%'}
                , {field: 'active_all_money', title: '活动金额',align:'center',width:'7%'}
                , {field: 'active_get_money', title: '已领活动金额',align:'center',width:'8%'}
                , {field: 'bet_money', title: '投注金额',align:'center',width:'7%'}
                , {field: 'bet_num', title: '投注次数',align:'center',width:'7%'}
                , {field: 'gift_money', title: '送礼金额',align:'center',width:'7%'}
                , {field: 'gift_num', title: '送礼次数',align:'center',width:'7%'}
                , {field: 'get_red_money', title: '领红包金额',align:'center',width:'8%'}
                , {field: 'get_red_num', title: '领红包次数',align:'center',width:'8%'}
                , {field: 'send_red_money', title: '发红包金额',align:'center',width:'8%'}
                , {field: 'send_red_num', title: '发红包次数',align:'center',width:'8%'}
                , {field: 'back_red_money', title: '中雷金额',align:'center',width:'7%'}
                , {field: 'back_red_num', title: '中雷次数',align:'center',width:'7%'}
                // , {field: 'status', title: '状态',align:'center'}
                // , {title: '操作', align: 'center', fixed: 'right', toolbar: '#data_control'}
            ]]
            , page: true
            , limit: 20
            , height: 'full-180'
        });

      //监听工具条
        table.on('tool(data_list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {

            } else if (obj.event === 'edit') {  //点击列表事件edit
                layer.open({
                    type: 2
                    , title: '修改信息'
                    , content: 'edit?id=' + data.id
                    , maxmin: true
                    , area: ['950px', '650px']
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
            add: function (obj) {
                layer.open({
                    type: 2,
                    title: '添加类型',
                    content: 'add?type_names='+active.type_names,
                    maxmin: true,
                    area: ['950px', '650px'],
                    btn: ['确定', '取消'],
                    yes: function (index, layero) {

                        var submit = layero.find('iframe').contents().find("#form_submit");
                        submit.click();
                    }
                });
            }
        };

        //监听搜索
        form.on('submit(data_search)', function (data) {
            var field = data.field;
            //执行重载
            table.reload('data_list', {
                where: field
            });
        });


        layui.use('laydate', function() {
            var laydate = layui.laydate;
            laydate.render({
                elem: '#date'
                ,type: 'datetime'
                ,trigger: 'click'
                ,range: '~'
                ,format: 'yyyy-M-d'
            });

        });

    });
</script>

