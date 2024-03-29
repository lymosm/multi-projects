<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="layui-form-item search-form">
    <form class="layui-form" method="post" action="">
    <a class="layui-btn layui-btn-sm" href="/wp-admin/admin.php?page=add_product">Add Product</a>
    <div class="layui-form-item">
        <label class="layui-form-label">Keyword</label>
        <div class="layui-input-block">
        <input type="text" name="keyword" placeholder="Title" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <span class="layui-btn layui-btn-sm" id="btn-search">Search</span>
        </div>
    </div>
    </form>
</div>

<table id="product-table" class="layui-table">
</table>
<style>
    form.layui-form {
        padding: 30px 30px 0;
        margin-top: 20px;
    }
    .layui-form-item {
        display: inline-flex;
    }
    .layui-input-block {
        margin-left: 0;
    }
    .layui-table-cell a.vim-u{
        color:#009688;
        margin: 0 5px;
    }
    .layui-table-cell a.vim-u.unapprovecomment{
        color:orange
    }
    .layui-table-cell a.vim-u.delete{
        color:red
    }
    .layui-table-cell input[type=number] {
        height: 28px;
        line-height: 1;
        float: left;
        margin-right: 5px;
        width: 60px;
    }
    .layui-table-cell input[type=number] {
        height: 28px;
        line-height: 1;
        float: left;
        margin-right: 5px;
        width: 60px;
    }
    .plb-sure{
        margin-top: 3px;
    }
    .layui-table-cell .comment-count-approved{
        box-sizing: border-box;
        display: block;
        padding: 0 5px;
        min-width: 24px;
        height: 2em;
        border-radius: 5px;
        background-color: #72777c;
        color: #fff;
        font-size: 12px;
        line-height: 24px;
        text-align: center;
        float:left;
        margin-right: 10px;
    }
    .layui-table-cell{
        height:auto;
    }
</style>
<script>
jQuery(function(){
    layui.use([ 'form','laypage', 'jquery', "table", "element"], function() {
        var table = layui.table,
            element = layui.element,
            $ = layui.jquery;
        
        var p_table = table.render({
            elem: '#product-table', 
            // height: 800, 
            url: ajaxurl, 
            limit: 20,
            method: "post",
            where: {
                    action: "getProductData", 
                    keyword: $("input[name='keyword']").val(),
                },
            page: true,
            cols: [[
                {field: 'id', title: 'ID', width:80, templet: function(a){
                    return a.LAY_INDEX;
                }},
                {field: 'id', title: 'Action', width: 200, templet: function(a){
                    var html = '<a href="/wp-admin/admin.php?page=add_product&id='+ a.id +'" class="vim-u">Edit</a>';
                     html += '<a href="javascript:;" class="vim-u delete" data-id="'+ a.id +'">Delete</a>';
                    return html;
                }},
                {field: 'image_url', title: 'image', width: 200, templet: function(a){
                    var html = '<img src="'+ a.image_url +'"/>';
                    return html;
                }},
                {field: 'product_title', title: 'product title', width: 300},
                {field: 'regular_price', title: 'Regular price', width: 120},
                {field: 'price', title: 'price', width: 100},
                {field: 'url', title: 'product url'}
            ]]
        });

        $("#btn-search").on("click", function(){
            p_table.reload({
                where: {
                    action: "getProductData", 
                    keyword: $("input[name='keyword']").val(),
                }
            });
        });

        $('body.wp-admin').on("click",'.delete',function(){
            var tb = $(this);
            var id = $(this).data('id');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                async: false,
                data: {
                    action: "deleteProduct",
                    id: id
                },
                success: function( res ) {
                    console.log(res);
                    if( res.code ){
                        tb.parents('tr').remove();
                    }
                },
                error:function(){
                    console.log('error');
                }
            });
        });
    });
});
</script>