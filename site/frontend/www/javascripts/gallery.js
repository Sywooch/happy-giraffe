jQuery.fn.pGallery = function() {
    var plugin = {};
    plugin.data = null,
        plugin.window = null,
        plugin.bg = null,
        plugin.st = null;

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
                    dist = 'prev';
                else
                    dist = 'next';
                plugin.goTo(dist);
                return false;
            });

            plugin.window.on('click', '#photo-thumbs li a', function() {
                if($(this).parent().hasClass('active'))
                    return false;
                $(this).parent().siblings('li.active').removeClass('active');
                $(this).parent().addClass('active');
                plugin.openImage($(this).attr('data-id'));
            });

            $('#photo-window-bg, #photo-window').fadeIn(600, function(){
                plugin.st = $('body').scrollTop();
                $('body').scrollTop(0).css('overflow', 'hidden');
                $('#photo-thumbs .jcarousel', plugin.window).jcarousel();
            });
        }, 'html');
    };

    plugin.openImage = function(id) {
        plugin.data.id = id;
        var data = plugin.data;
        data.go = 1;
        $.get(base_url + '/albums/wPhoto/', data, function(html) {
            $('#w-photo-content').html(html);
        }, 'html');
    };

    plugin.goTo = function(dist) {
        var data = plugin.data;
        data.dist = dist;
        data.go = 1;
        $.get(base_url + '/albums/wPhoto/', data, function(html) {
            $('#w-photo-content').html(html);
            plugin.data.id = $('#w-photo-content').find('#photo-item-id').val();
        }, 'html');
    }

    plugin.closeWindow = function() {
        this.window.remove();
        this.bg.remove();
        $('body').css('overflow', 'auto').scrollTop(this.st);
    }

    return this.each(function() {
        $(this).bind('click', function() {
            plugin.openWindow(this);
        });
    });
}

