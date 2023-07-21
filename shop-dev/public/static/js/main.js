var host = "https://lo.s.com/";
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

    $("#ls-btn-checkout").on("click", function(){
        var url = host + "Checkout/saveCheckout";
        var data = $("#checkout-form").serialize();
        var $loading = $("#ls-shade-box");
        $loading.addClass("active");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(res){
                if(res.code == 1){
                    ls_obj.message("added success");
                    location.href = res.data.redirect;
                }else{
                    ls_obj.message(res.msg);
                }
                
                $loading.removeClass("active");
            }
        });
    });

    $(".ls-ipt").on("focus", function(){
        var $this = $(this);
        var $parent = $this.parent();
        let $target = $parent.find(".ls-placeholder");
        $target.addClass("active");
    });

    $("#ls-btn-toggle-reg").on("click", function(){
        $("#ls-login-box").removeClass("active");
        $("#ls-reg-box").addClass("active");
    });
    $("#ls-btn-toggle-login").on("click", function(){
        $("#ls-login-box").addClass("active");
        $("#ls-reg-box").removeClass("active");
    });
    $("#ls-btn-login-show").on("click", function(){
        $("#ls-login-reg-box").addClass("active");
        $("#ls-shadow-box").addClass("active");
        $("#ls-btn-toggle-login").click();
    });
    $("#ls-btn-reg-show").on("click", function(){
        $("#ls-login-reg-box").addClass("active");
        $("#ls-shadow-box").addClass("active");
        $("#ls-btn-toggle-reg").click();
    });
    $("#ls-lr-close").on("click", function(){
        $("#ls-login-reg-box").removeClass("active");
        $("#ls-shadow-box").removeClass("active");
    });

    $("#ls-btn-login").on("click", function(){
        var url = host + "Checkout/saveCheckout";
        var data = $("#checkout-form").serialize();
        var $loading = $("#ls-shade-box");
        $loading.addClass("active");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(res){
                if(res.code == 1){
                    ls_obj.message("added success");
                    location.href = res.data.redirect;
                }else{
                    ls_obj.message(res.msg);
                }
                
                $loading.removeClass("active");
            }
        });
    });

});

var stripe_obj = {
    init: function(){
        var need = 1;
        if(typeof stripe === "undefined"){
            return ;
        }
        this.bind();
        var elementStyles = {
            base: {
                iconColor: '#666EE8',
                color: '#31325F',
                fontSize: '15px',
                '::placeholder': {
                      color: '#CFD7E0',
                }
            }
        };

        var elementClasses = {
            focus: 'focused',
            empty: 'empty',
            invalid: 'invalid',
        };
        var eles                = stripe.elements();
        var _card = eles.create( 'cardNumber', { style: elementStyles, classes: elementClasses } );
        var _exp  = eles.create( 'cardExpiry', { style: elementStyles, classes: elementClasses } );
        var _cvc  = eles.create( 'cardCvc', { style: elementStyles, classes: elementClasses } );
        this._card = _card;
        if(need){
            _card.mount( '#ele-card' );
            _exp.mount( '#ele-card-date' );
            _cvc.mount( '#ele-card-cvc' );

            var $ele_tip = jQuery("#ele-tip");
            _card.addEventListener( 'change', function( event ) {
                $ele_tip.hide();
            });
            _exp.addEventListener( 'change', function( event ) {
                $ele_tip.hide();
            });
            _cvc.addEventListener( 'change', function( event ) {
                $ele_tip.hide();
            });
        }
    },
    bind: function(){
        var _this = this;
        $('#stripe-box').on('click', '#btn-stripe', function(){
            $("#payment-method").val("stripe");
            stripe.createSource( _this._card ).then(_this.sourceRes);
        })
    },
    sourceRes: function(res){
        if(typeof res.source !== "undefined" && typeof res.source.id !== "undefined"){
            $("#stripe-source").val(res.source.id);
            $("#ls-btn-checkout").click();
        }else{
            var $ele_tip = $("#ele-tip");
            if(typeof res.error !== "undefined" && typeof res.error.message !== "undefined"){
                $ele_tip.html(res.error.message).show();
            }
        }
    }
}
stripe_obj.init();