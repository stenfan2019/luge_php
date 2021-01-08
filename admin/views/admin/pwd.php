<div class="layui-fluid">
    <form class="layui-form" action="" lay-filter="component-form-group">
    <div class="layui-card">
      <div class="layui-card-header">修改登录密码</div>
      <div class="layui-card-body" style="padding: 15px;">
          <div class="layui-form-item">
            <label class="layui-form-label">旧密码</label>
            <div class="layui-input-block">
              <input type="passwor" name="old_pwd" lay-verify="require" autocomplete="off" 
                            class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">新密码</label>
            <div class="layui-input-block">
              <input type="passwor" name="new_pwd" lay-verify="title" autocomplete="off" 
                         class="layui-input" >
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">重复一次</label>
            <div class="layui-input-block">
              <input type="passwor" name="re_pwd" lay-verify="title" autocomplete="off" 
                         class="layui-input" >
            </div>
          </div>
          
      </div>
    </div>
    
    
   <div class="layui-form-item layui-layout-admin">
            <div class="layui-input-block">
              <div class="layui-footer" style="left: 0;">
                <button class="layui-btn" lay-submit="" lay-filter="btnSubmit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
              </div>
            </div>
     </div>
 </form>   
  </div>


<script>
  layui.use(['index', 'form', 'laydate'], function(){
    var $ = layui.$
    ,admin = layui.admin
    ,element = layui.element
    ,form = layui.form;
    
   
    
    /* 监听提交 */
    form.on('submit(btnSubmit)', function(data){
     /* parent.layer.alert(JSON.stringify(data.field), {
        title: '最终的提交信息'
      })
      return false;*/
      admin.req({
	      type: 'post',
	      url: "/admin/pwd?data=1",
	      dataType: 'json',
	      data: data.field,
	      success: function (res) {
	          if (res.code == '0') {
	        	  layer.msg('成功', {icon: 1});
	          } else {
	              layer.msg('失败', {icon: 2});
	          }
	      }
      });
      return false;
    });
  });
</script>

