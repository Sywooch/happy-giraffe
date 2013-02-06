var ValentineVideos = {
    carousel : null
}

$(function() {
    ValentineVideos.carousel = $('.valentine-gallery_hold').jcarousel({
        list:'.valentine-gallery_ul',
        items:'.valentine-gallery_li'
    });

    $('.valentine-gallery_arrow__next').jcarouselControl({target:'+=1'});
    $('.valentine-gallery_arrow__prev').jcarouselControl({target:'-=1'});
});




