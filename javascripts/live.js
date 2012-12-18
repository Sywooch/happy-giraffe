$(function() {
    var $container = $("#liveList .items");

    $container.imagesLoaded(function() {
        $container.isotope({
            itemSelector : ".masonry-news-list_item:visible",
            masonry: {
                columnWidth: 240
            }
        });
    });

    Comet.prototype.receiveEvent = function(result, id) {
        var cap = $('.masonry-news-list_item.update-message:not(.new)');
        var c = $('.masonry-news-list_item.update-message.new');
        var counter = c.find('.count');
        if (cap.is(':visible'))
            $('.masonry-news-list_item.update-message').toggle();
        counter.text(parseInt(counter.text()) + 1);
    }

    comet.addEvent(10000, 'receiveEvent');
});