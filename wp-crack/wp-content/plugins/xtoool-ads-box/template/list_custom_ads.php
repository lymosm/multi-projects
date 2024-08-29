<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="adsbx-search-form">
    <form class="layui-form" method="post" action="">
    <a class="layui-btn layui-btn-sm" href="/wp-admin/admin.php?page=add_custom_ad">add custom ads</a>
    <div class="layui-form-item">
        <label class="layui-form-label">keyword: </label>
        <div class="layui-input-block">
        <input type="text" name="keyword" placeholder="Name" class="layui-input layui-input-sm">
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
    .adsbx-search-form{
        display: block;
    }
    form.layui-form {
        padding: 0 30px 0;
        margin-top: 10px;
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
    #layui-table-page1 .layui-laypage-limits select{
        width: 110px;
    }
    .layui-table-cell{
        height:auto;
    }
    .product_title{background:#eee;margin-right:10px;padding:5px 10px;border-radius: 10px;}
    .product_title a{line-height:30px;}
    textarea{min-width:100%; height:30px; background:#eee;line-height: 30px;}
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
                    action: "adsbx_custom_ads_list", 
                    keyword: $("input[name='keyword']").val(),
                },
            page: true,
            cols: [[ 
                {field: 'id', title: 'ID', width:60, templet: function(a){
                    return a.LAY_INDEX;
                }},
                {field: 'name', title: 'Name', width: 200},
                
                {field: 'shotcode', title: 'shortcode', width: 400},
                {field: 'list_id', title: 'Action', templet: function(a){
                    var html = '<a href="/wp-admin/admin.php?page=add_custom_ad&id='+ a.id +'" class="vim-u">Edit</a>';
                    html += '<a href="javascript:;" class="vim-u delete" data-id="'+ a.id +'">Delete</a>';
                    return html;
                }}
            ]]
        });

        $("#btn-search").on("click", function(){
            p_table.reload({
                where: {
                    action: "adsbx_custom_ads_list", 
                    keyword: $("input[name='keyword']").val(),
                }
            });
        });

        $('body.wp-admin').on("click",'.delete',function(){
            var tb = $(this);
            var id = $(this).data('id');
            const index = layer.confirm("Delete it?", {"title": false, "btn": ["Ok", "Cancel"]}, function(){
                layer.close(index);
                const index2 = layer.load(0);
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    async: false,
                    data: {
                        action: "adsbx_delete_custom_ads",
                        id: id
                    },
                    success: function( res ) {
                        layer.close(index2);
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
});
</script>