<style>
.add-form{padding:50px;}
</style>
<div class="layui-form-item add-form">
    <form class="layui-form" method="post" action="/wp-admin/admin.php?page=add_product&meted=add">
    <div class="layui-form-item">
        <label class="layui-form-label">main image url</label>
        <div class="layui-input-block">
        <input type="text" name="image_url" value="<?php echo isset($product['image_url']) ? $product['image_url'] : ''; ?>" placeholder="main image url" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">product title</label>
        <div class="layui-input-block">
        <input type="text" name="product_title" value="<?php echo isset($product['product_title']) ? $product['product_title'] : ''; ?>" placeholder="title" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">product url</label>
        <div class="layui-input-block">
        <input type="text" name="url" value="<?php echo isset($product['url']) ? $product['url'] : ''; ?>" placeholder="product url" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">regular price</label>
        <div class="layui-input-block">
        <input type="text" name="regular_price" value="<?php echo isset($product['regular_price']) ? $product['regular_price'] : ''; ?>" placeholder="regular price" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">price</label>
        <div class="layui-input-block">
        <input type="text" name="price" placeholder="price" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" name="id" value="<?php echo isset($product['id']) ? $product['id'] : ''; ?>">
        <button type="submit" class="layui-btn layui-btn-sm" >Save</button>
        </div>
    </div>
    </form>
</div>
