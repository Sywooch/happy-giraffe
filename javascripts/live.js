$(function() {
//    var $container = $("#liveList .items");
//    $container.imagesLoaded(function(){
//        $container.masonry({
//            itemSelector : ".masonry-news-list_item",
//            columnWidth : 240,
//            isAnimated: true
//        });
//    });
//
//    Comet.prototype.receiveEvent = function(result, id) {
//        var old = $('.masonry-news-list_item:data(blockId=' + result.blockId + ')');
//        var toRemove = (old.length > 0) ? old : $('.masonry-news-list_item:last');
//        toRemove.remove();
//
//        var $boxes = $(result.code);
//        $('#liveList .items').prepend($boxes).imagesLoaded(function() {
//            $('#liveList .items').masonry('reload');
//        });
//    }
//
//    comet.addEvent(10000, 'receiveEvent');

    var $container = $('#liveList .items');

    $container.imagesLoaded(function() {
        $container.isotope({
            itemSelector : '.masonry-news-list_item'
        });
    });

    Comet.prototype.receiveEvent = function(result, id) {
        var old = $('.masonry-news-list_item:data(blockId=' + result.blockId + ')');
        var toRemove = (old.length > 0) ? old : $('.masonry-news-list_item:last');
        toRemove.remove();

        $('#liveList .items').prepend($(result.code)).isotope('reloadItems').isotope({sortBy: 'original-order'});
    }

    comet.addEvent(10000, 'receiveEvent');
});