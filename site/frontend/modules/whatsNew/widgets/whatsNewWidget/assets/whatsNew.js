/**
 * Author: alexk984
 * Date: 20.12.12
 */

WhatsNew = {
    guest:false,
    offset:13,
    type:0,
    ajax:function (type, el) {
        $.post('/whatsNew/ajax/', {type:type}, function (response) {
            $('#broadcast').html(response);
            WhatsNew.init();
            WhatsNew.type = type;

            $('.broadcast-widget-menu ul li').removeClass('is-active');
            $(el).addClass('is-active');
        });
    },
    init:function () {
        if (!WhatsNew.guest) {
            $('#masonry-news-list-jcarousel .next').on('click', function () {
                if ($('.masonry-news-list_item:eq(10)').hasClass('jcarousel-item-visible'))
                    WhatsNew.redirect();
            });

            $('#masonry-news-list-jcarousel').jcarousel({
                list:'#masonry-news-list-jcarousel-ul',
                items:'.masonry-news-list_item'
            });

        } else {
            $('#masonry-news-list-jcarousel').jcarousel({
                list:'#masonry-news-list-jcarousel-ul',
                items:'.masonry-news-list_item'
            });
        }
        $('#masonry-news-list-jcarousel .prev').jcarouselControl({target:'-=4'});
        $('#masonry-news-list-jcarousel .next').jcarouselControl({target:'+=4'});
    },
    redirect:function(){
        switch(WhatsNew.type)
        {
            case 1:
                window.location.href = '/whatsNew/clubs/';
                break;
            case 3:
                window.location.href = '/whatsNew/blogs/';
                break;
            case 5:
                window.location.href = '/whatsNew/friends/';
                break;
            default:
                window.location.href = '/whatsNew/';
        }
    }
//    loadItems:function(){
//        $.post('/whatsNew/ajaxItems/', {offset:WhatsNew.offset}, function(response) {
//            $('#masonry-news-list-jcarousel-ul').append(response);
//            WhatsNew.offset += 4;
//        });
//    },
//    showItems:function(carousel, first, last, response){
//        for (i = 0; i < response.items.length; i++) {
//            carousel.add(i+1, response.items[i]);
//        }
//
//        carousel.size(response.items.length);
//    }
}

//function mycarousel_itemLoadCallback1(carousel, state){
//    console.log('load items');
//
//    // Check if the requested items already exist
//    if (carousel.has(carousel.first, carousel.last)) {
//        return;
//    }
//
//    $.post('/whatsNew/ajaxItems/', {first: carousel.first,last: carousel.last}, function(response) {
//        WhatsNew.showItems(carousel, carousel.first, carousel.last, response);
//    });
//}

$(function () {
    WhatsNew.init();
});