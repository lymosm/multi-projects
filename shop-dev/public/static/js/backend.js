"use strict";
layui.use(['element', 'layer', 'util', 'jquery', 'form', "table"], function() {
	var element = layui.element,
		layer = layui.layer,
		util = layui.util,
		$ = layui.$;
		
		var ls_obj = {
			message: function(msg){
				var $ing = $("#ls-alert-box");
				$ing.html(msg);
				$ing.addClass("active");
				setTimeout(function(){
					$ing.removeClass("active");
				}, 3000);
			}
		};

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
   

	var dragging = null;
	const menu_list = document.querySelector("#ls-menu-container");
	var drag_x = 0;
	if(menu_list != null){
		menu_list.ondragstart = function(e){
			dragging = e.target;
			drag_x = e.clientX;
		};
		menu_list.ondragover = function(e){
			var target = e.target;
			var parent = menu_list;
			var deep = 0;
			var diff = e.clientX - drag_x;
			if(diff > 20 && diff < 40){
				deep = 1;
			}else if(diff >= 40){
				deep = 2;
			}
			var menu_id = $(dragging).data("id");
			var parent_menu_id = 0;
			var dragging_deep_class = '';
			if(deep > 0){
				$(dragging).removeClass("ls-depth-1");
				$(dragging).removeClass("ls-depth-2");
				dragging_deep_class = "ls-depth-" + deep;
				$(dragging).addClass(dragging_deep_class);

				if(dragging_deep_class != ""){
					var $prevs = $(dragging).prev(".ls-menu-tr");
					console.log(dragging);
					$prevs.each(function(){
						if(parent_menu_id != 0){
							return ;
						}
						var $_this = $(this);
						if(! $_this.hasClass(dragging_deep_class)){
							parent_menu_id = $_this.data("id");
							console.log("parent id: " + parent_menu_id);
							// find parent menu id
							$("#menu-ipt-" + menu_id).val(parent_menu_id);
						}
					});
				}
				
			}else{
				$("#menu-ipt-" + menu_id).val("0");
				$(dragging).removeClass("ls-depth-1");
				$(dragging).removeClass("ls-depth-2");
			}
			console.log(dragging_deep_class);
			if(target.className.indexOf("ls-menu-tr") != -1 && target != dragging){
				if(_getIndex(dragging) < _getIndex(target)){
					parent.insertBefore(dragging, target.nextSibling);
				}else{
					parent.insertBefore(dragging, target);
				}
				console.log('6666');
				if(dragging_deep_class != ""){
					var $prevs = $(dragging).prev(".ls-menu-tr");
					console.log("5555");
					console.log(dragging);
					$prevs.each(function(){
						if(parent_menu_id != 0){
							return ;
						}
						var $_this = $(this);
						if(! $_this.hasClass(dragging_deep_class)){
							parent_menu_id = $_this.data("id");
							console.log("parent id: " + parent_menu_id);
							// find parent menu id
							$("#menu-ipt-" + menu_id).val(parent_menu_id);
						}
					});
				}
				

			}
		};
	}

	function _getIndex(el){
		var index = 1;
		if(! el || ! el.parentNode){
			return -1;
		}
		while(el && (el = el.previousElementSibling)){
			index++;
		}
		return index;
	}


	$(".ls-btn-add-menu").on("click", function(){
		var $this = $(this);
		var $parent = $this.parent();
		var $options = $parent.find(".ls-menu-checkbox");
		$options.each(function(){
			var $_this = $(this);
			var checked = $_this.prop("checked");
			if(checked){
				
				var $_parent = $_this.parent();
				var $target = $_parent.find(".ls-item-name");
				console.log($_parent)
				var name = $target.html();
				const url = $target.data("url");
				$.ajax({
					type: "POST",
					url: "/Admin/addMenu",
					data: {name: name, url: url},
					success: function(res){
						console.log(res);
						var id = res.data;
						var html = '<div class="ls-menu-tr" draggable="true" data-id=' + id + ' data-url="' + url + '">' + name + '</div>';
						$("#ls-menu-container").append(html);
						var ipt_html = '<input type="hidden" id="menu-ipt-' + id + '" name="menu_parent[' + id + ']" value="0">';
						ipt_html += '<input type="hidden" name="menu_id[' + id + ']" value="' + id + '">';
						$("#menu-form").append(ipt_html);
					}
				});
				
			}
		});
	});
	
	$("#ls-btn-menu-save").on("click", function(){
		const data = $("#menu-form").serialize();
		var $loading = $("#ls-shade-box");
		$loading.addClass("active");
		$.ajax({
			type: "POST",
			url: "/Admin/saveMenu",
			data: data,
			success: function(res){
				console.log(res);
				if(res.code == 1){
                    ls_obj.message("added success");
                }else{
                    ls_obj.message(res.msg);
                }
                
                $loading.removeClass("active");
			}
		});
	});
});