jQuery(document).ready(function($){
    console.log('main.js');
    $('.slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: true,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev">avant</button>',
        nextArrow: '<button type="button" class="slick-next">apres</button>',
    });
});