<style>
.add-form{padding:50px;}
</style>
<div class="layui-form-item add-form">
    <form class="layui-form" method="post" action="/wp-admin/admin.php?page=add_product&meted=add">
    <div class="layui-form-item">
        <label class="layui-form-label">main image url</label>
        <div class="layui-input-block">
        <input type="text" name="image_url" placeholder="main image url" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">product title</label>
        <div class="layui-input-block">
        <input type="text" name="product_title" placeholder="title" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">product url</label>
        <div class="layui-input-block">
        <input type="text" name="url" placeholder="product url" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">regular price</label>
        <div class="layui-input-block">
        <input type="text" name="regular_price" placeholder="regular price" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">price</label>
        <div class="layui-input-block">
        <input type="text" name="price" placeholder="price" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <button type="submit" class="layui-btn layui-btn-sm" >Save</button>
        </div>
    </div>
    </form>
</div>
