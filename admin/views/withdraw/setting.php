<div class="layui-fluid">
    <form class="layui-form" action="" lay-filter="component-form-group">
    <div class="layui-card">
      <div class="layui-card-header">主播提现手续费设置</div>
      <div class="layui-card-body" style="padding: 15px;">
          <div class="layui-form-item">
            <label class="layui-form-label">免费次数</label>
            <div class="layui-input-block">
              <input type="text" name="anthor_free_times" lay-verify="title" autocomplete="off" 
                           placeholder="当天免费提现次数" class="layui-input" value="<?=$anchor_set['anthor_free_times']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">最低提现</label>
            <div class="layui-input-block">
              <input type="text" name="anthor_min_money" lay-verify="title" autocomplete="off" 
                          placeholder="单次最小提现金额" class="layui-input" value="<?=$anchor_set['anthor_min_money']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">单次最大</label>
            <div class="layui-input-block">
              <input type="text" name="anthor_max_money" lay-verify="title" autocomplete="off" 
                         placeholder="单次最大提现金额" class="layui-input" value="<?=$anchor_set['anthor_max_money']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">手续费</label>
            <div class="layui-input-block">
              <input type="text" name="anthor_fee"  autocomplete="off" placeholder="超过免得次数手续费百分比"
                         class="layui-input" value="<?=$anchor_set['anthor_fee']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">最大次数</label>
            <div class="layui-input-block">
              <input type="text" name="anthor_day_times"  autocomplete="off" placeholder="一天最大提现次数" 
                         class="layui-input" value="<?=$anchor_set['anthor_day_times']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">最低手续费</label>
            <div class="layui-input-block">
              <input type="text" name="anthor_one_fee"  autocomplete="off" placeholder="单笔最低手续费" 
                         class="layui-input" value="<?=isset($anchor_set['anthor_one_fee']) ? $anchor_set['anthor_one_fee'] : ''?>">
            </div>
          </div>
      </div>
    </div>
    
    <div class="layui-card">
      <div class="layui-card-header">用户提现手续费设置</div>
        <div class="layui-card-body" style="padding: 15px;">
          <div class="layui-form-item">
            <label class="layui-form-label">免费次数</label>
            <div class="layui-input-block">
              <input type="text" name="user_free_times" lay-verify="title" autocomplete="off" 
                          placeholder="当天免费提现次数" class="layui-input" value="<?=$user_set['user_free_times']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">最低提现</label>
            <div class="layui-input-block">
              <input type="text" name="user_min_money" lay-verify="title" autocomplete="off" placeholder="单次最小提现金额" 
                         class="layui-input" value="<?=$user_set['user_min_money']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">单次最大</label>
            <div class="layui-input-block">
              <input type="text" name="user_max_money" lay-verify="title" autocomplete="off" placeholder="单次最大提现金额" 
                       class="layui-input" value="<?=$user_set['user_max_money']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">手续费</label>
            <div class="layui-input-block">
              <input type="text" name="user_fee"  autocomplete="off" placeholder="超过免得次数手续费百分比" 
                       class="layui-input" value="<?=$user_set['user_fee']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">最大次数</label>
            <div class="layui-input-block">
              <input type="text" name="user_day_times"  autocomplete="off" placeholder="一天最大提现次数" 
                        class="layui-input" value="<?=$user_set['user_day_times']?>">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">最低手续费</label>
            <div class="layui-input-block">
              <input type="text" name="user_one_fee"  autocomplete="off" placeholder="单笔最低手续费" 
                        class="layui-input" value="<?=isset($user_set['user_one_fee']) ? $user_set['user_one_fee']:''?>">
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
    ,layer = layui.layer
    ,laydate = layui.laydate
    ,form = layui.form;
    
    form.render(null, 'component-form-group');

    laydate.render({
      elem: '#LAY-component-form-group-date'
    });
    
    
    /* 监听提交 */
    form.on('submit(btnSubmit)', function(data){
     /* parent.layer.alert(JSON.stringify(data.field), {
        title: '最终的提交信息'
      })
      return false;*/
      admin.req({
	      type: 'post',
	      url: "/withdraw/setting?data=1",
	      dataType: 'json',
	      data: data.field,
	      success: function (res) {
	          if (res.code == '0') {
	        	  layer.msg('编辑成功', {icon: 1});
	          } else {
	              layer.msg('添加失败', {icon: 2});
	          }
	      }
      });
      return false;
    });
  });
</script>

