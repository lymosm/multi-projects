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
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
    });
});