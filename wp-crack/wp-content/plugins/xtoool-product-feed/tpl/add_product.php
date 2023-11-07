<style>
.add-form{padding:50px;}
</style>
<div class="layui-form-item add-form">
    <form class="layui-form" method="post" action="/wp-admin/admin.php?page=add_product&meted=add">
    <div class="layui-form-item">
        <label class="layui-form-label">主图 url</label>
        <div class="layui-input-block">
        <input type="text" name="image_url" placeholder="请输入产品主图的url" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">product title</label>
        <div class="layui-input-block">
        <input type="text" name="product_title" placeholder="请输入产品标题" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">product url</label>
        <div class="layui-input-block">
        <input type="text" name="url" placeholder="请输入产品url" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">regular price</label>
        <div class="layui-input-block">
        <input type="text" name="regular_price" placeholder="请输入产品原价" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">price</label>
        <div class="layui-input-block">
        <input type="text" name="price" placeholder="请输入产品销售价" lay-verify="required" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <button type="submit" class="layui-btn layui-btn-sm" >确认</button>
        </div>
    </div>
    </form>
</div>
