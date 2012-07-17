var photosAjaxMasonry = {

    load:function (element, event) {
        var button = $(element);
        if (button.attr('data-loading') == '1')
            return false;
        button.attr('data-loading', '1').text('Загрузка фотографий');

        var url = button.attr('href');

        $.post(url, function (data) {
            var html = data.html;
            var newItems = $(html).find('#photosList ul.items li');

            var nextUrl = $(html).find('#more-btn').attr('href');
            console.log(nextUrl);
            if (nextUrl) {
                button.attr('href', nextUrl);
            } else {
                button.hide();
            }

            $('#photosList ul.items').append(newItems);
            $('#photosList ul.items').imagesLoaded(function () {
                $('#photosList ul.items').masonry('appended', newItems, true);
                button.attr('data-loading', '0').text(' Показать еще фотографии ');
                $(".img > a").pGallery({'singlePhoto':true, 'entity':'Album', 'entity_id':button.attr('data-albumid')});
            });


        }, 'json');

        return false;
    }
}