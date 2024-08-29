<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<style>
.add-form{padding:50px;}
</style>
<div class="layui-form-item add-form">
    <form class="layui-form" method="post" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">name</label>
            <div class="layui-input-block">
            <input type="text" name="name" value="<?php echo isset($data['name']) ? esc_html($data['name']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">code</label>
            <div class="layui-input-block">
                <textarea name="content" rows="6" cols="80"><?php echo isset($data['content']) ? esc_html($data['content']) : ''; ?></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="id" value="<?php echo isset($data['id']) ? esc_html($data['id']) : ''; ?>">
            <button type="button" class="layui-btn layui-btn-sm" lay-submit lay-filter="ads-form">Save</button>
            </div>
        </div>
    </form>
</div>
<script>
jQuery(function($){
	var file_ids = [],
		file_index = 0;
    layui.use(["form", "layer", "upload", "element"], function(){
		var form = layui.form,
			upload = layui.upload,
			element = layui.element,
			layer = layui.layer;
		var submiting = false;
		form.on('submit(ads-form)', function(data){
			var data = data.field;
			data.action = "adsbx_save_custom_ads";
            const index = layer.load(0);
			if(submiting){
				return ;
			}
			submiting = true;
			$.post({
				url: ajaxurl,
				data: data,
				success: function(res){
					if(res.code != 1){
						submiting = false;	
                        layer.close(index);
						layer.msg(res.msg);
					}else{
						location.href = "/wp-admin/admin.php?page=custom_list";
					}
				}
			});
			return false;
		});
    });
});
</script>