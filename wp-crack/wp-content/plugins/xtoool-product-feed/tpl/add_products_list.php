<style>
.add-form{padding:50px;}
.product_title{background:#eee;margin-right:10px;padding:0 5px;line-height:30px;}
</style>
<div class="layui-form-item add-form">
    <?php if( empty($list_data) ){ ?>
    <form class="layui-form" method="post" action="/wp-admin/admin.php?page=add_products_list&meted=add">
    <div class="layui-form-item">
        <label class="layui-form-label">List title</label>
        <div class="layui-input-block">
        <input type="text" name="list_title" placeholder="请输入列表标题" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
        <input type="num" name="order" placeholder="排序" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择展示的产品</label>
        <div class="layui-input-block">
            <input type="hidden" name="products" lay-verify="required" class="layui-input layui-input-sm" readonly>
            <div class="layui-input products_html"></div>
            <select name="products_list">
                <option value="">--选择产品--</option>
                <?php 
                $products_html ='';
                foreach( $products as $product ){
                    $products_html .= '<option value="'. $product->id .'">'. $product->product_title .'</option>';
                }
                echo esc_html($products_html);
                ?>
            </select>
        </div>
    </div>
    <?php } else { ?>
        <form class="layui-form" method="post" action="/wp-admin/admin.php?page=add_products_list&meted=add&list_id=<?php echo esc_html($list_data->list_id);?>">
    <div class="layui-form-item">
        <label class="layui-form-label">List title</label>
        <div class="layui-input-block">
        <input type="text" name="list_title" placeholder="请输入列表标题" value="<?php echo esc_html($list_data->list_title);?>" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
        <input type="num" name="order" placeholder="排序" value="<?php echo esc_html($list_data->order);?>"  lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择展示的产品</label>
        <div class="layui-input-block">
            <input type="hidden" name="products" value="<?php echo esc_html(str_replace(',','|',$list_data->ids));?>" lay-verify="required" class="layui-input layui-input-sm" readonly>
            <div class="layui-input products_html">
                <?php
                    $titles = explode(',', $list_data->product_title); 
                    for($i=0; $i< count($titles); $i++){
                        echo '<span class="product_title">' . $titles[$i] . '</span>';
                    }
                ?>
            </div>
            <select name="products_list">
                <option value="">--选择产品--</option>
                <?php 
                $products_html ='';
                foreach( $products as $product ){
                    $products_html .= '<option value="'. $product->id .'">'. $product->product_title .'</option>';
                }
                echo esc_html($products_html);
                ?>
            </select>
        </div>
    </div>
    <?php } ?>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <button type="submit" class="layui-btn layui-btn-sm" >确认</button>
        </div>
    </div>
    </form>
</div>
<script>
jQuery(function(){

    
   layui.use([ 'jquery', "element"], function() {
        var element = layui.element,
        $ = layui.jquery;
        $('.layui-unselect dd').on("click",function(){
            var value_this = $(this).attr('lay-value');
            var value_this_html = $(this).html();
            var products = $('input[name="products"]').val();
            var products_html = $('.products_html').html();

            arr = products.split('|');
            if( value_this  && $.inArray(value_this,arr) < 0 ){
                v2 = products?products + '|':'';
                $('input[name="products"]').val( v2 + value_this );
                $('.products_html').html( products_html + '<span class="product_title">' + value_this_html + '</span>' );
            }
        });
    });
});
</script>
