<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:70px; ">关键词查询</label>
                    <div class="layui-input-block">
                        <input type="text" name="keyword" placeholder="请输入关键词" autocomplete="off" class="layui-input">
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
                <div class="layui-inline" >
                    <button class="layui-btn layuiadmin-btn-list" data-type="add">添加主播</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
           
            <table id="data_list" lay-filter="data_list"></table>
            <script type="text/html" id="data_control">
                <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">
                    <i class="layui-icon"></i>编辑
                </a>
                <a class="layui-btn layui-btn-warm layui-btn-xs" lay-href="/cash/anchor?params={{d.id}}|uid" lay-text="{{d.nickname}}" >
                    <i class="layui-icon"></i>现金
                </a>
                <a class="layui-btn layui-btn-xs" lay-href="/gift/record?params={{d.id}}|anchor_id" lay-text="{{d.nickname}}礼物记录">
                    <i class="layui-icon"></i>礼物
                </a>
                {{#  if(d.is_freeze == '0'){ }}
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="freeze">
                    <i class="layui-icon"></i>冻结                              
                </a>
                {{#  } else { }}
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="freeze">
                    <i class="layui-icon"></i>解冻                          
                </a>
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
            , url: '/anchor/list?data=1'
            , cols: [[
                  {field: 'id', title: '主播ID',align:'left',width:'7%'}
                , {field: 'username', title: '主播账号',align:'left',width:'11%'}
                , {field: 'mobile', title: '手机号',align:'left',width:'12%'}
                , {field: 'nickname', title: '昵称',align:'left',width:'12%'}
                , {field: 'reg_time', title: '注册时间',align:'center',width:'12%'}
                , {field: 'reg_ip', title: '注册ip',align:'center',width:'12%'}
                , {field: 'follower', title: '关注人数',align:'center',width:'10%'}
                , {field: 'fans', title: '粉丝数',align:'center',width:'9%'}
                , {field: 'live_rate', title: '直播提成%',align:'center',width:'7%'}
                , {field: 'game_rate', title: '游戏提成%',align:'center',width:'7%'}
                , {field: 'amount', title: '账号余额',align:'center',width:'9%'}
                , {field: 'income_gift', title: '直播收益',align:'center',width:'9%'}
                , {field: 'income_game', title: '游戏收益',align:'center',width:'9%'}
                , {field: 'withdraw', title: '累计提现',align:'center',width:'9%'}
                , {field: 'last_login_time', title: '登录时间',align:'center',width:'12%'}
                , {field: 'last_login_ip', title: '登录ip',align:'center',width:'12%'}
                , {title: '操作', align: 'center', fixed: 'right', toolbar: '#data_control',width:'20%'}
            ]]
            , page: true
            , limit: 20
            , height: 'full-180'
        });

      //监听工具条
        table.on('tool(data_list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'freeze') {
            	var data = obj.data;
                if (obj.event === 'freeze') {    //点击列表事件del
                    layer.confirm('您确定对当前账号执行此操作？', function (index) {
                        admin.req({
                            type: 'post',
                            url: '/anchor/freeze?id='+ data.id+'&is_freeze='+data.is_freeze,
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
                }
            } else if (obj.event === 'edit') {  //点击列表事件edit
                layer.open({
                    type: 2
                    , title: '修改信息'
                    , content: '/anchor/edit?id=' + data.id
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

        //监听搜索
       form.on('submit(data_search)', function (data) {
            var field = data.field;

            //执行重载
            table.reload('data_list', {
                where: field
            });
        });

        var $ = layui.$, active = {
            add: function () {
                layer.open({
                    type: 2, 
                    title: '添加主播', 
                    content: '/anchor/add', 
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

