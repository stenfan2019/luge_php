<div class="layui-fluid">
    <div class="layui-card">
       <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:70px; ">主播ID</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?=$keyword?>"  name="UID" placeholder="主播ID" autocomplete="off" class="layui-input">
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
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
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
            , url: '/cash/anchor?data=1&<?=$params?>'
            , cols: [[
                  {field: 'deal_number', title: '交易单号',align:'left',width:'10%'}
                , {field: 'anchor_id', title: '主播ID',align:'left'}
                , {field: 'deal_type_title', title: '交易类型',align:'left'}
                , {field: 'deal_money', title: '交易金额',align:'center'}
                , {field: 'deal_category_title', title: '支出类型',align:'center'}
                , {field: 'balance', title: '账户余额',align:'center'}
                , {field: 'memo', title: '说明',align:'center'}
                , {field: 'create_time', title: '交易时间',align:'center'}
               
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

