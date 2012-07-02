var pGallery_photos = {};
jQuery.fn.pGallery = function(options) {
    var plugin = {};
    plugin.data = options,
        plugin.window = null,
        plugin.bg = null,
        plugin.history = null,
        plugin.init = false;

    plugin.openWindow = function(id) {
        if(this.init)
            return false;
        this.init = true;
        this.bg = $('<div id="photo-window-bg" style="display:none"></div>');
        this.window = $('<div id="photo-window" style="display:none"></div>');
        this.window.css('top', $(document).scrollTop());
        this.bg.appendTo('body');
        this.window.appendTo('body');

        delete this.data.go;
        this.data.id = id;

        this.history = new AjaxHistory('photo_view');
        this.history.loadCallback = function(id, url) {
            if(/\/photo(\d+)/.test(url)) {
                var id = url.split(/\/photo(\d+)/)[1];
                if(plugin.init == true)
                    plugin.openImage(id);
                else
                    plugin.openWindow(id);
            } else {
                if(plugin.init)
                    plugin.closeWindow();
            }
        }

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
                plugin.openImage($(this).attr('data-id'));
                return false;
            });

            $('body').css('overflow', 'hidden');
            var newUrl = plugin.getEntityUrl() + 'photo' + plugin.data.id + '/';
            saveAsAjaxView(newUrl);
            plugin.history.changeBrowserUrl(newUrl);
            $('#photo-window-bg, #photo-window').fadeIn(600, function(){
                $('#photo-thumbs .jcarousel', plugin.window).jcarousel();
                $('#photo-thumbs .prev', plugin.window).jcarouselControl({target: '-=7',fullScroll:true,carousel: $('#photo-thumbs .jcarousel', plugin.window)});
                $('#photo-thumbs .next', plugin.window).jcarouselControl({target: '+=7',fullScroll:true,carousel: $('#photo-thumbs .jcarousel', plugin.window)});
                plugin.preloadPhotos($('#photo-thumbs', this.window).find('li.active').index());
                $(window).resize();
            });

            if(pGallery_photos[id].description != null)
                $('#photo', this.window).find('.photo-comment .title-text').show().text(pGallery_photos[id].description);
            else
                $('#photo', this.window).find('.photo-comment .title-text').hide().text('');
        }, 'html');
    };

    plugin.openImage = function(id, callback) {
        var photo = $('#photo', this.window);
        photo.find('.img').children('img').attr({src : pGallery_photos[id].src});
        if(photo.find('.in').size() > 0) {
            if(pGallery_photos[id].title != null) {
                photo.find('.in').show().find('.title-text').text(pGallery_photos[id].title);
            } else {
                if(photo.find('.in').find('a.edit').size() == 0)
                    photo.find('.in').hide().text('');
                else
                    photo.find('.in').find('.title-text').text('');
            }
        }
        if(pGallery_photos[id].description != null)
            photo.find('.photo-comment .title-text').show().text(pGallery_photos[id].description);
        else
            photo.find('.photo-comment .title-text').hide().text('');

        photo.find('.user-info').replaceWith(pGallery_photos[id].avatar);

        this.data.id = id;
        var link = $('#photo-thumbs li a[data-id='+id+']' ,this.window);
        delete this.data.dist;
        var data = this.data;
        data.go = 1;

        /*$('#photo-window-in', this.window).append('<div id="loading"><div class="in"><img src="/images/test_loader.gif">Загрузка</div></div>');*/

        $.get(base_url + '/albums/wPhoto/', data, function(html) {
            var newUrl = plugin.getEntityUrl() + 'photo' + plugin.data.id + '/';
            saveAsAjaxView(newUrl);

            $('#w-photo-content', plugin.window).html(html);
            link.parent().siblings('li.active').removeClass('active');
            link.parent().addClass('active');
            if(callback)
                callback();
            /*$('#photo-window-in', plugin.window).children('#loading').remove();*/
        }, 'html');
        plugin.preloadPhotos(link.parent().index());
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
        this.openImage(newLink.attr('data-id'), function() {
            $('#photo-thumbs .jcarousel', $('#photo-window')).jcarousel('scroll', offset);
        });
    };

    plugin.preloadPhotos = function(index) {
        var size = 7;
        $('#photo-thumbs', this.window).find('li:gt('+(index - size)+')').each(function(i) {
            var link = $(this).children('a');
            if(link.attr('data-loaded') == 'true')
                return true;
            link.attr('data-loaded', true);
            var id  = link.attr('data-id');
            var image = new Image();
            image.src = pGallery_photos[id].src;
            if(i == size)
                return false;
        });
    };

    plugin.closeWindow = function() {
        plugin.init = false;
        $('#photo-window-bg, #photo-window').fadeOut(600, function(){
            plugin.history.changeBrowserUrl(plugin.getEntityUrl());
            $('body').css('overflow', 'auto');
            plugin.window.remove();
            plugin.bg.remove();
        });
    }

    plugin.getEntityUrl = function() {
        return document.location.href.replace(/photo(.*)/, '');
    }

    if(/\/photo(\d+)/.test(document.location.href)) {
        var id = document.location.href.split(/\/photo(\d+)/)[1];
        plugin.openWindow(id);
    }

    $(document).keyup(function(e) {
        if (e.keyCode == 27 && plugin.init == true) {
            plugin.closeWindow();
        }
    });


    return this.each(function() {
        $(this).bind('click', function() {
            plugin.openWindow($(this).attr('data-id'));
        });
    });
}

function saveAsAjaxView(url){
    var url = str_replace('http://'+window.location.hostname, '', url);
    _gaq.push(['_trackPageview', url]);
    yaCounter11221648.hit(url);
    console.log(url);
}

function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
}