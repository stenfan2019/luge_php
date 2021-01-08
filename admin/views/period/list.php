<<style>
<!--
.layui-form-label{text-align:center;width:50px; }
-->
</style>
<div class="layui-fluid">
    <div class="layui-card">
          
         <div class="layui-form layui-card-header layuiadmin-card-header-auto" >
            <div class="layui-form-item" >

                <div class="layui-inline" >
                    <label class="layui-form-label">彩期</label>
                    <div class="layui-input-inline">
                        <input type="text" name="lottery_number" placeholder="请输彩期" autocomplete="off" class="layui-input">
                    </div>
                </div>
                 <div class="layui-inline">
                    <label class="layui-form-label">彩种</label>
                    <div class="layui-input-inline">
                        <?=$select_html?>
                    </div>
                </div>
               
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="data_search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn">查询</i>
                    </button>
                </div>
                
            </div>
        </div>  
        
        <div class="layui-card-body">
            
            <table id="data_list" lay-filter="data_list"></table>
            <script type="text/html" id="data_control">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-next"></i>派彩</a>
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
            , url: '/period/list?data=1'
            , cols: [[
                  {field: 'lottery_number', title: '彩期',align:'left'}
                , {field: 'lottery_name', title: '彩票名称',align:'left'}
                , {field: 'lottery_code', title: '彩票编号',align:'left'}
                , {field: 'period_code', title: '开奖号码',align:'center'}
                , {field: 'type_title', title: '类型1',align:'center'}
                , {field: 'end_time', title: '结束时间',align:'center'}
                , {field: 'envelop_time', title: '封盘时间',align:'center'}
                , {field: 'state_title', title: '类型2',align:'center'}
                , {field: 'create_time', title: '创建时间',align:'center'}
                , {field: 'update_time', title: '派奖时间',align:'center'}
                , {title: '操作',width:'15%', align: 'center', fixed: 'right', toolbar: '#data_control'}
            ]]
            , page: true
            , limit: 20
            , height: 'full-180'
        });

      //监听工具条
        table.on('tool(data_list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
            	var data = obj.data;
                if (obj.event === 'del') {    //点击列表事件del
                    layer.confirm('确定对'+data.lottery_name+'第'+data.lottery_number+'期进行重新派彩？', function (index) {
                        admin.req({
                            type: 'post',
                            url: '/gift/del?id='+ data.id,
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
                }
            } else if (obj.event === 'edit') {  //点击列表事件edit
                layer.open({
                    type: 2
                    , title: '修改礼物信息'
                    , content: '/gift/edit?id=' + data.id
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
                    title: '添加礼物', 
                    content: '/gift/add', 
                    maxmin: true, 
                    area: ['550px', '450px'], 
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

