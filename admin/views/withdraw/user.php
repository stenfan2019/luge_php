<div class="layui-fluid">
    <div class="layui-card">
       <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:70px; ">主播ID</label>
                    <div class="layui-input-block">
                        <input type="text"   name="aid" placeholder="主播ID" autocomplete="off" class="layui-input">
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
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-href="/cash/user?params={{d.user_id}}|uid" lay-text="{{d.username}}">
                  <i class="layui-icon layui-icon-survey"></i>流水</a>
                {{#  if(d.state == '1'){ }}
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="refuse"><i class="layui-icon layui-icon-close"></i>拒绝</a>
                <a class="layui-btn layui-btn-xs" lay-event="pass"><i class="layui-icon layui-icon-ok"></i>通过</a>
                {{#  } else { }}
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
            , url: '/withdraw/user?data=1'
            , cols: [[
                  {field: 'user_id', title: 'UID',align:'left'}
                , {field: 'mobile', title: '用户账号',align:'left'}
                , {field: 'username', title: '用户昵称',align:'left'}
                , {field: 'bank_name', title: '银行名称',align:'left'}
                , {field: 'bank_number', title: '银行卡号',align:'center'}
                , {field: 'bank_address', title: '银行地址',align:'center'}
                , {field: 'account', title: '开户人',align:'center'}
                , {field: 'amount', title: '提现金额',align:'center'}
                , {field: 'fee', title: '手续费',align:'center'}
                , {field: 'state_title', title: '状态',align:'center'}
                , {field: 'create_time', title: '交易时间',align:'center'}
                , {title: '操作', align: 'center', fixed: 'right', toolbar: '#data_control',width:"18%"}
                
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
        //监听菜单栏
        table.on('tool(data_list)', function (obj) {
        	var data = obj.data;
            if (obj.event === 'refuse') {
            	layer.confirm('您确定拒绝本次提现申请？', function (index) {
                    admin.req({
                        type: 'post',
                        url: '/withdraw/user-refuse?id='+ data.id,
                        dataType: 'json',
                        data: {id: data.id},
                        success: function (res) {
                            if (res.code == '0') {
                                layer.msg('成功', {icon: 1}, function () {
                                    //obj.del();
                                    table.reload('data_list');
                                    //layer.close(index);
                                });
                            } else {
                                layer.msg('失败', {icon: 2});
                            }
                        }
                    });
            	});
            }else if(obj.event === 'pass') {

            	layer.confirm('您确定通过本次提现申请？', function (index) {
                    admin.req({
                        type: 'post',
                        url: '/withdraw/user-pass?id='+ data.id,
                        dataType: 'json',
                        data: {id: data.id},
                        success: function (res) {
                            if (res.code == '0') {
                                layer.msg('成功', {icon: 1}, function () {
                                    //obj.del();
                                    table.reload('data_list');
                                    //layer.close(index);
                                });
                            } else {
                                layer.msg('失败', {icon: 2});
                            }
                        }
                    });
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

