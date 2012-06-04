jQuery.fn.pGallery = function() {
    var plugin = {};
    plugin.openWindow = function(link) {
        var bg = $('<div id="photo-window-bg" style="display:none"></div>');
        var window = $('<div id="photo-window" style="display:none"></div>');
        bg.appendTo('body');
        window.appendTo('body');
        $.get(base_url + '/albums/wPhoto/' + $(link).attr('data-id') + '/', {}, function(data) {
            $('#photo-window').append(data);
            $('#photo-window-bg, #photo-window').fadeIn(600, function(){
                var st = $('body').scrollTop();
                $('body').scrollTop(0).css('overflow', 'hidden');
            });
        }, 'html');

    };

    return this.each(function() {
        $(this).bind('click', function() {
            plugin.openWindow(this);
        });
    });
}