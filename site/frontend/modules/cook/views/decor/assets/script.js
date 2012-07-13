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

            container.imagesLoaded(function () {
                container.append(newItems).masonry('appended', newItems, true);
            });

        }, 'json');

        return false;
    })

})