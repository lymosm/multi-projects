<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<style>
.add-form{padding:50px;}
</style>
<div class="layui-form-item add-form">
    <form class="layui-form" method="post" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">banner name</label>
            <div class="layui-input-block">
            <input type="text" name="name" value="<?php echo isset($data['name']) ? esc_html($data['name']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">main image url</label>
            <div class="layui-input-block">
            <input type="text" name="image_url" value="<?php echo isset($data['image_url']) ? esc_html($data['image_url']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">product title</label>
            <div class="layui-input-block">
            <input type="text" name="title" value="<?php echo isset($data['title']) ? esc_html($data['title']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">product description</label>
            <div class="layui-input-block">
                <textarea name="desc" rows="6" cols="80"><?php echo isset($data['desc']) ? esc_html($data['desc']) : ''; ?></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">regular price</label>
            <div class="layui-input-block">
            <input type="text" name="regular_price" value="<?php echo isset($data['regular_price']) ? esc_html($data['regular_price']) : ''; ?>" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">price</label>
            <div class="layui-input-block">
            <input type="text" name="price" value="<?php echo isset($data['price']) ? esc_html($data['price']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">shop button text</label>
            <div class="layui-input-block">
            <input type="text" name="shop_btn_text" value="<?php echo isset($data['shop_btn_text']) ? esc_html($data['shop_btn_text']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">shop button link</label>
            <div class="layui-input-block">
            <input type="text" name="shop_btn_link" value="<?php echo isset($data['shop_btn_link']) ? esc_html($data['shop_btn_link']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">subcribe button text</label>
            <div class="layui-input-block">
            <input type="text" name="sub_btn_text" value="<?php echo isset($data['sub_btn_text']) ? esc_html($data['sub_btn_text']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">subcribe button link</label>
            <div class="layui-input-block">
            <input type="text" name="sub_btn_link" value="<?php echo isset($data['sub_btn_link']) ? esc_html($data['sub_btn_link']) : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
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
			data.action = "adsbx_save_ads";
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
						location.href = "/wp-admin/admin.php?page=bannder_ad_list";
					}
				}
			});
			return false;
		});
    });
});
</script>