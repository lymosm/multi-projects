"use strict";
layui.use(['element', 'layer', 'util', 'jquery', 'form', "table"], function() {
	var element = layui.element,
		layer = layui.layer,
		util = layui.util,
		$ = layui.$;
		
	
   $("#btn-pass").on("click", function(){
		layer.open({
			title: "修改密码",
			type: 2,
			area: ["480px", "320px"],
			content: '{$url_pass}',
			end: function(){
				//tablens.reload();
			}
		}); 
	});
   

});