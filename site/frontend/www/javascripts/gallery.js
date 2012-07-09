var pGallery = {
    photos : {},
    currentPhoto : null,
    first : null,
    last : null
};

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
            pGallery.currentPhoto = plugin.data.id;
            $('#photo-window').append(html);

            plugin.window.find('.window-close').bind('click', function() {plugin.closeWindow();return false;});

            plugin.window.on('click', '#photo a.next', function() {
                plugin.next();
                return false;
            });

            plugin.window.on('click', '#photo a.prev', function() {
                plugin.prev();
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
                plugin.preloadPhotos();
                $(window).resize();
            });

            if(pGallery.photos[id].description != null)
                $('#photo', this.window).find('.photo-comment .title-text').show().text(pGallery.photos[id].description);
            else
                $('#photo', this.window).find('.photo-comment .title-text').hide().text('');
        }, 'html');
    };

    plugin.openImage = function(id, callback) {
        var photo = $('#photo', this.window);
        photo.find('.img').find('img').attr({src : pGallery.photos[id].src});
        if(photo.find('.in').size() > 0) {
            if(pGallery.photos[id].title != null) {
                photo.find('.in').show().find('.title-text').text(pGallery.photos[id].title);
            } else {
                if(photo.find('.in').find('a.edit').size() == 0)
                    photo.find('.in').hide().text('');
                else
                    photo.find('.in').find('.title-text').text('');
            }
        }
        if(pGallery.photos[id].description != null)
            photo.find('.photo-comment .title-text').show().text(pGallery.photos[id].description);
        else
            photo.find('.photo-comment .title-text').hide().text('');

        photo.find('.user-info').replaceWith(pGallery.photos[id].avatar);

        this.data.id = id;
        var link = $('#photo-thumbs li a[data-id='+id+']' ,this.window);
        delete this.data.dist;
        var data = this.data;
        data.go = 1;

        /*$('#photo-window-in', this.window).append('<div id="loading"><div class="in"><img src="/images/test_loader.gif">Загрузка</div></div>');*/

        $.get(base_url + '/albums/wPhoto/', data, function(html) {
            pGallery.currentPhoto = plugin.data.id;
            var newUrl = plugin.getEntityUrl() + 'photo' + plugin.data.id + '/';
            plugin.history.changeBrowserUrl(newUrl);
            saveAsAjaxView(newUrl);

            $('#w-photo-content', plugin.window).html(html);
            link.parent().siblings('li.active').removeClass('active');
            link.parent().addClass('active');
            if(callback)
                callback();
            /*$('#photo-window-in', plugin.window).children('#loading').remove();*/
        }, 'html');
        plugin.preloadPhotos();
    };

    plugin.goTo = function(dist) {
        var data = plugin.data;
        data.dist = dist;
        data.go = 1;

        var goTo = pGallery.photos.dist;
        if (goTo = null)
        this.openImage(newLink.attr('data-id'));
    };

    plugin.next = function () {
        console.log('next');
        var next = pGallery.photos[pGallery.currentPhoto].next;
        var goTo =  (next != null) ? next : pGallery.first;
        this.openImage(goTo);
    };

    plugin.prev = function () {
        console.log('prev');
        var prev = pGallery.photos[pGallery.currentPhoto].prev;
        var goTo =  (prev != null) ? prev : pGallery.last;
        this.openImage(goTo);
    };

    plugin.preloadPhotos = function() {
        var depth = 3;
        var images = [];
        var currentPrev = pGallery.photos[pGallery.currentPhoto];
        var currentNext = pGallery.photos[pGallery.currentPhoto];
        for (var i = 0; i < depth; i++) {
            if (currentNext.next != null) {
                currentNext = pGallery.photos[currentNext.next];
                images.push(currentNext.src);
            }

            if (currentPrev.prev != null) {
                currentPrev = pGallery.photos[currentPrev.prev];
                images.push(currentPrev.src);
            }
        }

        $(images).each(function() {
            $('<img/>')[0].src = this;
            console.log(this);
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