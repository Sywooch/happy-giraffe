var pGallery = {
    photos : {},
    currentPhoto : null,
    first : null,
    last : null,
    start: null
};

jQuery.fn.pGallery = function(options) {
    var plugin = {};
    plugin.data = options,
        plugin.window = null,
        plugin.bg = null,
        plugin.history = null,
        plugin.init = false;
        plugin.originalTitle = null;
        plugin.entity_url = null;
        plugin.start_url = document.location.href;

    plugin.openWindow = function(id) {
        if(! this.init) {
            this.init = true;
            this.originalTitle = document.title;
            this.bg = $('<div id="photo-window-bg" style="display:none"></div>');
            this.window = $('<div id="photo-window" style="display:none"></div>');
            this.window.css('top', $(document).scrollTop());
            this.bg.appendTo('body');
            this.window.appendTo('body');

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
        }

        delete this.data.go;
        this.data.id = id;

        $.get(base_url + '/albums/wPhoto/', plugin.data, function(html) {
            pGallery.currentPhoto = plugin.data.id;
            $('#photo-window').html(html);

            //$('#photo-window-in', this.window).css('left', Math.ceil(getScrollBarWidth()/2) + 'px');

            plugin.window.find('.close').bind('click', function() {plugin.closeWindow();return false;});

            plugin.window.on('click', '#photo a.next', function() {
                plugin.next();
                return false;
            });

            plugin.window.on('click', '#photo a.prev', function() {
                plugin.prev();
                return false;
            });

            plugin.window.on('click', '.re-watch', function() {
                plugin.openImage(pGallery.start);
                $('.photo-container', this.window).show();
                $('.rewatch-container', this.window).hide();
                return false;
            });

            plugin.window.on('click', '.more-albums .img > a', function() {
                plugin.data.entity = $(this).parent().data('entity');
                plugin.data.entity_id = $(this).parent().data('entityId');
                plugin.data.entity_url = $(this).parent().data('entityUrl');
                plugin.openWindow($(this).parent().data('id'));
            });

            /*$('html').on('click', function() {
                plugin.closeWindow();
            });

            $('#photo-window-in').on('click', function(event){
                event.stopPropagation();
            });*/

            /*plugin.window.on('click', '#photo-thumbs li a', function() {
                if($(this).parent().hasClass('active'))
                    return false;
                plugin.openImage($(this).attr('data-id'));
                return false;
            });*/

            $('body').css('.top-nav-fixed overflow', 'hidden');
            var newUrl = plugin.getEntityUrl() + 'photo' + plugin.data.id + '/';
            if (typeof history.pushState !== 'undefined') {
                plugin.history.changeBrowserUrl(newUrl);
                if (plugin.data.entity == 'Contest') {
                    /*if ($('#photo-window .vk_share_button').length > 0)
                        $('#photo-window .vk_share_button').html(VK.Share.button(document.location.href,{type: 'round', text: 'Мне нравится'}));
                    if (typeof twttr != 'undefined' && typeof twttr.widgets != 'undefined')
                        twttr.widgets.load();
                    if (typeof ODKL != 'undefined') {
                        ODKL.initialized = false;
                        ODKL.init();
                    }
                    $.getJSON("http://graph.facebook.com", { id : document.location.href }, function(json){
                        $('.fb-custom-share-count').html(json.shares || '0');
                    });*/
                    $(".auth-service.odnoklassniki a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
                    $(".auth-service.vkontakte a").eauth({"popup":{"width":585,"height":350},"id":"vkontakte"});
                    $(".auth-service.facebook a").eauth({"popup":{"width":585,"height":290},"id":"facebook"});
                    $(".auth-service.twitter a").eauth({"popup":{"width":900,"height":550},"id":"twitter"});
                }
            }
            $('#photo-window-bg, #photo-window').fadeIn(600, function(){
                /*$('#photo-thumbs .jcarousel', plugin.window).jcarousel();
                $('#photo-thumbs .prev', plugin.window).jcarouselControl({target: '-=7',fullScroll:true,carousel: $('#photo-thumbs .jcarousel', plugin.window)});
                $('#photo-thumbs .next', plugin.window).jcarouselControl({target: '+=7',fullScroll:true,carousel: $('#photo-thumbs .jcarousel', plugin.window)});*/
                plugin.preloadPhotos();
                $(window).resize();
            });

            console.log(id);
            var title = pGallery.photos[id].title;
            if (title != null)
                document.title = pGallery.photos[id].title;

            window.location = $('#gallery-top-link').attr('href');
        }, 'html');
    };

    plugin.openImage = function(id, callback) {
        /*var photo = $('#photo', this.window);
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

        photo.find('.user-info').replaceWith(pGallery.photos[id].avatar);*/

        var indexEl = $('.photo-info > .count > span')
        var titleEl = $('.photo-info > .title', this.window);
        var descriptionEl = $('.photo-comment > p', this.window);
        var avatarEl = $('.user', this.window);
        var imgEl = $('#photo img', this.window);

        var title = pGallery.photos[id].title;
        var description = pGallery.photos[id].description;
        var avatar = pGallery.photos[id].avatar;

        if (avatar != null)
            avatarEl.html(pGallery.photos[id].avatar);
        imgEl.attr('src', pGallery.photos[id].src);
        indexEl.text(pGallery.photos[id].idx);
        (title == null) ? titleEl.hide() : titleEl.text(title).show();
        (description == null) ? descriptionEl.hide() : descriptionEl.text(description).show();
        if (title != null)
            document.title = title;

        this.data.id = id;
        var link = $('#photo-thumbs li a[data-id='+id+']' ,this.window);
        delete this.data.dist;
        var data = this.data;
        data.go = 1;

        /*$('#photo-window-in', this.window).append('<div id="loading"><div class="in"><img src="/images/test_loader.gif">Загрузка</div></div>');*/

        pGallery.currentPhoto = plugin.data.id;
        $('#photo_download').attr('href', '/albums/download/id/' + pGallery.currentPhoto + '/');
        var newUrl = plugin.getEntityUrl() + 'photo' + plugin.data.id + '/';
        plugin.history.changeBrowserUrl(newUrl);

        link.parent().siblings('li.active').removeClass('active');
        link.parent().addClass('active');
        if(callback)
            callback();
        $.get(base_url + '/albums/wPhoto/', data, function(html) {
            $('#w-photo-content', plugin.window).html(html);
            if (plugin.data.entity == 'Contest') {
                /*if ($('#photo-window .vk_share_button').length > 0)
                    $('#photo-window .vk_share_button').html(VK.Share.button(document.location.href,{type: 'round', text: 'Мне нравится'}));
                if (typeof twttr != 'undefined' && typeof twttr.widgets != 'undefined')
                    twttr.widgets.load();
                if (typeof ODKL != 'undefined') {
                    ODKL.initialized = false;
                    ODKL.init();
                }*/
                $(".auth-service.odnoklassniki a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
                $(".auth-service.vkontakte a").eauth({"popup":{"width":585,"height":350},"id":"vkontakte"});
                $(".auth-service.facebook a").eauth({"popup":{"width":585,"height":290},"id":"facebook"});
                $(".auth-service.twitter a").eauth({"popup":{"width":900,"height":550},"id":"twitter"});
            }
            /*$('#photo-window-in', plugin.window).children('#loading').remove();*/
            window.location = $('#gallery-top-link').attr('href');
        }, 'html');
        plugin.preloadPhotos();
        return false;
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
        if (next == pGallery.start && Object.keys(pGallery.photos).length > 3) {
            this.showAlbumEnd();
        } else {
            (next !== null) ? this.openImage(next) : this.openImage(pGallery.first);
        }
    };

    plugin.prev = function () {
        console.log('prev');
        var prev = pGallery.photos[pGallery.currentPhoto].prev;
        var goTo =  (prev != null) ? prev : pGallery.last;
        this.openImage(goTo);
    };

    plugin.showAlbumEnd = function() {
        $('.photo-container', this.window).hide();
        $('.rewatch-container', this.window).show();
    };

    plugin.preloadPhotos = function() {
        var depth = 3;
        var images = [];
        var currentPrev = pGallery.photos[pGallery.currentPhoto];
        var currentNext = pGallery.photos[pGallery.currentPhoto];
        for (var i = 0; i < depth; i++) {
            currentNext = (currentNext.next == null) ? pGallery.photos[pGallery.first] : pGallery.photos[currentNext.next];
            currentPrev = (currentPrev.prev == null) ? pGallery.photos[pGallery.last] : pGallery.photos[currentPrev.prev];
            images.push(currentNext.src);
            images.push(currentPrev.src);
        }

        $(images).each(function() {
            $('<img/>')[0].src = this;
        });

    };

    plugin.closeWindow = function() {
        plugin.init = false;
        $('#photo-window-bg, #photo-window').fadeOut(600, function(){
            //$('html').off('click');
            document.title = plugin.originalTitle;
            if (! plugin.data.singlePhoto)
                plugin.history.changeBrowserUrl(plugin.start_url);
            $('.top-nav-fixed body').css('overflow', 'auto');
            plugin.window.remove();
            plugin.bg.remove();
        });
    }

    plugin.getEntityUrl = function() {
        var base = (plugin.data.entity_url === null || plugin.data.entity_url === undefined) ? document.location.href : plugin.data.entity_url;
        return base.replace(/photo(.*)/, '');
    }

    if(/\/photo(\d+)/.test(document.location.href)) {
        var id = document.location.href.split(/\/photo(\d+)/)[1];
        if (! plugin.data.singlePhoto)
            plugin.openWindow(id);
    }

    $(document).keyup(function(e) {
        if (e.keyCode == 27 && plugin.init == true) {
            plugin.closeWindow();
        }
    });

    return this.each(function() {
        $(this).unbind('click').bind('click', function() {
            plugin.openWindow($(this).data('id'));
        });
    });
}

function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
}