jQuery(function($){
	'use strict';

	var $ror_loading = {
		show: function(){
			$("#ror-loading").show();
		},
		hide: function(){
			$("#ror-loading").hide();
		}
	};
	var ror = {
    	getList: function(page){
			var keyword = $("#ror-keyword").val();
			if(typeof page === "undefined" || ! page){
				page = 0;
			}
			var params = {action: "ajaxLybpList", keyword: keyword, page: page};
            $ror_loading.show();
            $.ajax({
                type: "GET",
                data: params,
                url: ajaxurl,
                success: function(res){
                    $ror_loading.hide();
                    if(res.status == 1){
                        var html = "";
                        for(var i in res.data.list){
                            var item = res.data.list[i];
                            html += "<tr>" +
                                '<td>' + item.id + '</td>' +
                                "<td>" + item.ip + "</td>" +
                                "<td>" + item.email + "</td>" +
                                "<td>" + item.status + "</td>" +
                                "<td>" + item.added_date + "</td>" +
                                "</tr>";
                        }
    					$("#ror-table tbody").html(html);
    					$("#total-items").html(res.data.count);

    					var page = res.data.page,
    					 	page_total = Math.round(res.data.count / res.data.pagesize);
    					$("#page").html(page);
    					$("#current-page").val(page);
    					if(page > 1){
							$("#ror-page-prev").addClass("active");
    					}else{
    						$("#ror-page-prev").removeClass("active");
    					}
    					if(page_total == 0){
    						page_total = 1;
    					}
    					if(page == page_total){
    						$("#ror-page-next").removeClass("active");
    					}else{
    						$("#ror-page-next").addClass("active");
    					}
    					$("#total-page").html(page_total);
                  	}
               	}
            });
    	}
    }

    $("#ror-btn-save").on("click", function(){
		var $this = $(this);
		var $form = $this.parents("form");
		var form_data = $form.serialize();
		$ror_loading.show();
		form_data += "&action=ajaxRorSettingSave";
		$.ajax({
			type: "POST",
			data: form_data,
			url: ajaxurl,
			success: function(res){
				$ror_loading.hide();
				alert(res.data);
			}
		});
	});

});