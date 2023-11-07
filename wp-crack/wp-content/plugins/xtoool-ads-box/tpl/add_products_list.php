<style>
.add-form{padding:50px;}
.product_title{background:#eee;margin-right:10px;padding:0 5px;line-height:30px;}
.plb-product-item{
    position: relative;
    display: inline-block;
    margin-right: 10px;
}
.plb-btn-remove{
    position: absolute;
    right: 0;
    top: 0;
    cursor: pointer;
}
</style>
<div class="layui-form-item add-form">
    <?php if( empty($list_data) ){     
    ?>
    <form class="layui-form" method="post" action="/wp-admin/admin.php?page=add_products_list&meted=add">
    <div class="layui-form-item">
        <label class="layui-form-label">List title</label>
        <div class="layui-input-block">
        <input type="text" name="list_title" placeholder="List Title" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Sort</label>
        <div class="layui-input-block">
        <input type="num" name="order" placeholder="Sort" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">chosen show product</label>
        <div class="layui-input-block">
            <input type="hidden" name="products" id="plb-products" lay-verify="required" class="layui-input layui-input-sm" readonly>
            <div class="layui-input products_html"></div>
            <select name="products_list">
                <option value="">--chosen product--</option>
                <?php 
                $products_html ='';
                foreach( $products as $product ){
                    $products_html .= '<option value="'. esc_html($product->id) .'">'. esc_html($product->product_title) .'</option>';
                }
                echo $products_html;
                ?>
            </select>
        </div>
    </div>
    <?php } else { 

        ?>
        <form class="layui-form" method="post" action="/wp-admin/admin.php?page=add_products_list&meted=add&list_id=<?php echo esc_html($list_data->list_id);?>">
    <div class="layui-form-item">
        <label class="layui-form-label">List title</label>
        <div class="layui-input-block">
        <input type="text" name="list_title" placeholder="List title" value="<?php echo esc_html($list_data->list_title);?>" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Sort</label>
        <div class="layui-input-block">
        <input type="num" name="order" placeholder="Sort" value="<?php echo esc_html($list_data->order);?>"  lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">chosen show product</label>
        <div class="layui-input-block">
            <input type="hidden" name="products" id="plb-products" value="<?php echo esc_html(str_replace(',','|',$list_data->ids));?>" lay-verify="required" class="layui-input layui-input-sm">
            <div class="layui-input products_html">
                <?php
                    $titles = explode(',', $list_data->product_title); 
                    $ids = explode(',', $list_data->ids);
                    for($i=0; $i< count($titles); $i++){
                        echo '<div class="plb-product-item"><span class="product_title">' . $titles[$i] . '</span><span class="plb-btn-remove" data-id="' . $ids[$i] . '">X</span></div>';
                    }
                ?>
            </div>
            <select name="products_list">
                <option value="">--chosen product--</option>
                <?php 
                $products_html ='';
                foreach( $products as $product ){
                    $products_html .= '<option value="'. $product->id .'">'. $product->product_title .'</option>';
                }
                echo $products_html;
                ?>
            </select>
        </div>
    </div>
    <?php } ?>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <button type="submit" class="layui-btn layui-btn-sm" >Save</button>
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
                var vv = '<div class="plb-product-item"><span class="product_title">' + value_this_html 
                + '</span><span class="plb-btn-remove" data-id="' + value_this + '">X</span></div>';
                $('input[name="products"]').val( v2 + value_this );
                $('.products_html').html( products_html + vv );
            }
        });

        $(".products_html").on("click", ".plb-btn-remove", function(){
            var $this = $(this);
            const id = String($this.data("id"));
            const ids = $("#plb-products").val();
            var arr = ids.split("|");
            arr = arr.filter(function(item){
                console.log(item + "===" + id);
                return item !== id;
            });
            /*
            const index = arr.indexOf(id);
            if(index !== -1){
                arr.splice(index, 1);
            }
            */
            const ids_new = arr.join("|");
            $("#plb-products").val(ids_new);
            $this.parent().remove();
        });
    });
});
</script>
