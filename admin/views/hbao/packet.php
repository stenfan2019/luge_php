<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:70px; ">关键词查询</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?=$params?>" name="keyword" placeholder="请输入关键词" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                   <?=$search_label?>
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
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-view"></i>查看明细</a>
                
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
            , url: '/hbao/packet?data=1<?=$params ? "&keyword=$params&search=user_id":''?>'
            , cols: [[
                  {field: 'room_id', title: '房间id',align:'left'}
                , {field: 'user_id', title: '用户ID',align:'left'}
                , {field: 'user_name', title: '发包用户',align:'left'}
                , {field: 'money', title: '金额/个数',align:'center', templet: function(res){
                    var n = res.money/100;
                    return    n.toFixed(2)+' / ' + res.number
                }}
                , {field: 'mine_str', title: '雷点',align:'center'}
                , {field: 'created', title: '发包时间',align:'center'}
                , {field: 'invalid_date', title: '结束时间',align:'center'}
                , {field: 'type_title', title: '状态',align:'center'}
                , {field: 'is_mine_title', title: '有雷',align:'center'}
                , {field: 'is_hit_mine_title', title: '杀率命中',align:'center'}
                , {field: 'draw_num', title: '已抢',align:'center'}
                , {field: 'odds', title: '赔率',align:'center', templet: function(res){
                    var n = res.odds/100;
                    return    n.toFixed(2)
                }}
                , {title: '操作', align: 'center', fixed: 'right', toolbar: '#data_control',width:'8%'}
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
                   /* layer.confirm('确定删除此内容？', function (index) {
                        admin.req({
                            type: 'post',
                            url: '/hbao/del?id='+ data.id,
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

                    });*/
                }
            } else if (obj.event === 'edit') {  //点击列表事件edit
                layer.open({
                    type: 2
                    , title: '红包详情'
                    , content: '/hbao/ptview?hbao_id=' + data.id
                    , maxmin: true
                    , area: ['950px', '600px']
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

