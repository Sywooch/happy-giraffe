jQuery.fn.pGallery = function() {
    var plugin = {};
    plugin.data = null,
        plugin.window = null,
        plugin.bg = null;

    plugin.openWindow = function(link) {
        this.bg = $('<div id="photo-window-bg" style="display:none"></div>');
        this.window = $('<div id="photo-window" style="display:none"></div>');
        this.window.css('top', $(document).scrollTop());
        this.bg.appendTo('body');
        this.window.appendTo('body');

        this.data = $.parseJSON($(link).attr('data-gallery').replace(/'/g, '"'));

        $.get(base_url + '/albums/wPhoto/', plugin.data, function(html) {
            $('#photo-window').append(html);

            plugin.window.find('.window-close').bind('click', function() {plugin.closeWindow();return false;});

            plugin.window.on('click', '#photo a.next, #photo a.prev', function() {
                if($(this).hasClass('prev'))
                    dist = -1;
                else
                    dist = 1;
                plugin.goTo(dist);
                return false;
            });

            plugin.window.on('click', '#photo-thumbs li a', function() {
                if($(this).parent().hasClass('active'))
                    return false;
                plugin.openImage(this);
            });

            $('body').css('overflow', 'hidden');
            $('#photo-window-bg, #photo-window').fadeIn(600, function(){
                document.location.hash = 'photo-' + plugin.data.id;
                $('#photo-thumbs .jcarousel', plugin.window).jcarousel();
                $('#photo-thumbs .prev', plugin.window).jcarouselControl({target: '-=1',carousel: $('#photo-thumbs .jcarousel', plugin.window)});
                $('#photo-thumbs .next', plugin.window).jcarouselControl({target: '+=1',carousel: $('#photo-thumbs .jcarousel', plugin.window)});
            });
        }, 'html');
    };

    plugin.openImage = function(link, callback) {
        plugin.data.id = $(link).attr('data-id');
        delete plugin.data.dist;
        var data = plugin.data;
        data.go = 1;
        $.get(base_url + '/albums/wPhoto/', data, function(html) {
            document.location.hash = 'photo-' + plugin.data.id;
            $('#w-photo-content').html(html);
            $(link).parent().siblings('li.active').removeClass('active');
            $(link).parent().addClass('active');
            if(callback)
                callback();
        }, 'html');
    };

    plugin.goTo = function(dist) {
        var data = plugin.data;
        data.dist = dist;
        data.go = 1;

        var active = $('#photo-thumbs li.active');
        var index = active.index();
        active.removeClass('active');
        var offset = index + dist;
        if(offset > $('#photo-thumbs li').size() - 1)
            offset = 0;
        else if(offset < 0)
            offset = $('#photo-thumbs li').size() - 1;
        var newLink = $('#photo-thumbs li:eq(' + (offset) + ') a');
        this.openImage(newLink, function() {
            $('#photo-thumbs .jcarousel', $('#photo-window')).jcarousel('scroll', offset);
        });
    }

    plugin.closeWindow = function() {
        $('#photo-window-bg, #photo-window').fadeOut(600, function(){
            document.location.hash = '';
            $('body').css('overflow', 'auto');
            plugin.window.remove();
            plugin.bg.remove();
        });
    }

    if(/photo-/.test(document.location.hash)) {
        var id = document.location.hash.split('-')[1];
        if($(this + '[data-id='+id+']').size() > 0)
            plugin.openWindow($(this + '[data-id='+id+']').get(0));
    }

    return this.each(function() {
        $(this).bind('click', function() {
            plugin.openWindow(this);
        });
    });
}