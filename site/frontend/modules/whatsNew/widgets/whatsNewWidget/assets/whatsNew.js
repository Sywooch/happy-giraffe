/**
 * Author: alexk984
 * Date: 20.12.12
 */

WhatsNew = {
    guest:false,
    offset:13,
    page:1,
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
                WhatsNew.page++;
                if (WhatsNew.page * 4 > WhatsNew.offset - 8)
                    WhatsNew.loadItems();
            });
            $('#masonry-news-list-jcarousel .prev').on('click', function () {
                if (WhatsNew.page > 1)
                    WhatsNew.page--;
            });
        }


        $('#masonry-news-list-jcarousel .prev').jcarouselControl({target:'-=4'});
        $('#masonry-news-list-jcarousel .next').jcarouselControl({target:'+=4'});
    },
    redirect:function () {
        switch (WhatsNew.type) {
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
    loadItems:function () {
        setTimeout(function () {
            $.post('/whatsNew/moreItems/', {offset:WhatsNew.offset}, function (response) {
                $('#masonry-news-list-jcarousel-ul').append(response);
                WhatsNew.offset += 4;
                WhatsNew.Carousel.jcarousel('reload');
            });
        }, 500)
    }
}

$(function () {
    setTimeout(function(){WhatsNew.init()}, 1);
});