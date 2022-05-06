var host = "http://lo.s.com/";
var ls_obj = {
    message: function(msg){
        var $ing = $("#ls-alert-box");
        $ing.html(msg);
        $ing.addClass("active");
        setTimeout(function(){
            $ing.removeClass("active");
        }, 2000);
    }
}
$(function(){
    $('#ls-home-top').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
    });

    $('#p-img-gallary').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        accessibility: false,
        arrows: false
    });

    $('#p-img-gallary-thumb').slick({
        infinite: false,
        slidesToShow: 4,
        slidesToScroll: 4,
    });

    $("#p-img-gallary-thumb").on("click", ".gallary-thumb-item",  function(){
        var $this = $(this);
    	$(".thumb-img-inner").removeClass("active");
    	$this.find(".thumb-img-inner").addClass("active");
    	var index = $this.data("slick-index");
    	$("#p-img-gallary").slick("slickGoTo", index);
    });
    var $target_obj = $("#p-img-gallary-thumb .gallary-thumb-item");
    if($target_obj.length > 0){
    	$($target_obj[0]).find(".thumb-img-inner").addClass("active");
    }

    $("#ls-btn-add-cart").on("click", function(){
        var url = host + "Cart/addToCart";
        var data = {
            id: $("#product-id").val(),
            qty: $("#qty").val()
        };
        var $loading = $("#ls-shade-box");
        $loading.addClass("active");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(res){
                ls_obj.message("added success");
                $loading.removeClass("active");
            }
        });
    });

});