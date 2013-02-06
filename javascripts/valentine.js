var ValentineVideos = {
    initialIndex: 6,
    carousel : null,

    choose : function(index) {
        var el = $($('.valentine-gallery_ul > li').get(index));
        el.siblings('.active').removeClass('active');
        el.addClass('active');

        $('.valentine-recognition .margin-b30').html($('#embedTmpl').tmpl({vimeo_id : el.data('vimeoId')}));
    }
}

$(function() {
    ValentineVideos.carousel = $('.valentine-gallery_hold').jcarousel({
        list:'.valentine-gallery_ul',
        items:'.valentine-gallery_li'
    });

    $('.valentine-gallery_arrow__next').jcarouselControl({target:'+=1'});
    $('.valentine-gallery_arrow__prev').jcarouselControl({target:'-=1'});

    ValentineVideos.carousel.jcarousel('scroll', ValentineVideos.initialIndex - 2, false);
    ValentineVideos.choose(ValentineVideos.initialIndex);
});




