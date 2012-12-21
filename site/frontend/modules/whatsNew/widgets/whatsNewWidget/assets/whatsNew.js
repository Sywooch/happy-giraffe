/**
 * Author: alexk984
 * Date: 20.12.12
 */

WhatsNew = {
    guest:false,
    offset:13,
    type:0,
    Carousel:null,
    ajax:function (type, el) {
        $.post('/whatsNew/ajax/', {type:type}, function (response) {
            $('#broadcast').replaceWith(response);
            WhatsNew.init();
            WhatsNew.type = type;

            $('.broadcast-widget-menu ul li').removeClass('is-active');
            $(el).addClass('is-active');
        });
    },
    init:function () {
        if (!WhatsNew.guest) {
            WhatsNew.Carousel = $('#masonry-news-list-jcarousel').jcarousel({
                list:'#masonry-news-list-jcarousel-ul',
                items:'.masonry-news-list_item'
            });

            $('#masonry-news-list-jcarousel .next').on('click', function () {
                if ($('.masonry-news-list_item:eq(10)').hasClass('jcarousel-item-visible'))
                    WhatsNew.redirect();
            });

        } else {
            WhatsNew.Carousel = $('#masonry-news-list-jcarousel').jcarousel({
                list:'#masonry-news-list-jcarousel-ul',
                items:'.masonry-news-list_item'
            });

            $('#masonry-news-list-jcarousel .next').on('click', function () {
                //WhatsNew.loadItems();
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
    },
    loadItems:function(){
        $.post('/whatsNew/moreItems/', {offset:WhatsNew.offset}, function(response) {
            $('#masonry-news-list-jcarousel-ul').append(response);
            $('#masonry-news-list-jcarousel-ul li').removeClass('jcarousel-item-last');
            $('#masonry-news-list-jcarousel-ul li:last').addClass('jcarousel-item-last')
            WhatsNew.offset += 4;
            //WhatsNew.Carousel.jcarousel('myUpdate');
        });
    }
}

$(function () {
    WhatsNew.init();
});