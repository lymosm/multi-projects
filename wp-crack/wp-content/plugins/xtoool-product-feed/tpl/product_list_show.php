<div class="layui-form-item search-form">
    <form class="layui-form" method="post" action="">
    <a class="layui-btn layui-btn-sm" href="/wp-admin/admin.php?page=add_products_list">增加产品组件</a>
    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
        <input type="text" name="keyword" placeholder="请输入组件title关键词" class="layui-input layui-input-sm">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        <span class="layui-btn layui-btn-sm" id="btn-search">查询</span>
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
    .esr-sure{
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
        
        //执行渲染
        var p_table = table.render({
            elem: '#product-table', //指定原始表格元素选择器（推荐id选择器）
            // height: 800, //容器高度
            url: ajaxurl, //数据接口
            limit: 20,
            method: "post",
            where: {
                    action: "getProductListData", 
                    keyword: $("input[name='keyword']").val(),
                },
            page: true,
            cols: [[ //表头 
                {field: 'list_id', title: 'ID', width:60, fixed: 'left', templet: function(a){
                    return a.LAY_INDEX;
                }},
                {field: 'list_title', title: '展示标题', width: 200},
                {field: 'list_id', title: 'Action', width: 150, templet: function(a){
                    var html = '<a href="/wp-admin/admin.php?page=add_products_list&list_id='+ a.list_id +'" class="vim-u">Edit</a>';
                    html += '<a href="javascript:;" class="vim-u delete" data-id="'+ a.list_id +'">Delete</a>';
                    return html;
                }},
                {field: 'list_id', title: '代码', width: 350, templet: function(a){
                    var html = '<textarea>[esr_products_list id="'+ a.list_id +'"]</textarea>';
                    return html;
                }},
                {field: 'product_title', title: 'products', width: 600, templet: function(a){
                    titles = a.product_title.split(",");
                    urls = a.product_url.split(",");
                    var html = '';
                    for(var i=0; i<titles.length; i++){
                        html += '<span class="product_title"><a href="'+ urls[i] +'">' + titles[i] + '</a></span>';
                    }
                    return html;
                }},
            ]]
        });

        $("#btn-search").on("click", function(){
            p_table.reload({
                where: {
                    action: "getProductListData", 
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
                    action: "deleteProductList",
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