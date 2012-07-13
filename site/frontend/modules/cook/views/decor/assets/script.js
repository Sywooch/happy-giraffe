/**
 * Created with JetBrains PhpStorm.
 * User: farik
 * Date: 13.07.12
 * Time: 13:41
 * To change this template use File | Settings | File Templates.
 */


$(function () {

    var container = $('#decorlv ul.items');

    container.imagesLoaded(function () {
        container.masonry({
            itemSelector:'li',
            columnWidth:240
        });
    });

    $('#more-btn').bind('click', function (event) {
        if ($(this).attr('data-loading') == '1')
            return false;
        $(this).attr('data-loading', '1').text('Загрузка фотографий');

        var url = $(this).attr('href');

        $.post(url, function (data) {
            var html = data.html;
            //$(html).find('#decorlv ul.items li').appendTo($('#decorlv ul.items'));
            var newItems = $(html).find('#decorlv ul.items li');

            var url = $(html).find('#more-btn').attr('href');
            if (url) {
                $('#more-btn').attr('href', url);
            } else {
                $('#more-btn').hide();
            }

            container.append(newItems);
            container.imagesLoaded(function () {
                container.masonry('appended', newItems, true);
                $('#more-btn').attr('data-loading', '0').text('Показать еще фотографии');
                $(".img > a").pGallery({'singlePhoto':true,'entity':'CookDecorationCategory','entity_id':null});
            });


        }, 'json');

        return false;
    })

})