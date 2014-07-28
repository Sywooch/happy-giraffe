(function() {
    function f(ko, FavouriteWidget) {
        function roundSlice(array, start, quantity) {
            if (quantity > 0) {
                if ((array.length - start) < quantity)
                    return array.slice(start).concat(array.slice(0, quantity - (self.length - start)));
                else
                    return array.slice(start, start + quantity);
            } else {
                quantity = Math.abs(quantity);
                if (start < (quantity + 1))
                    return array.slice(start - quantity).concat(array.slice(0, start));
                else
                    return array.slice(start - quantity + 1, start + 1);
            }
        }

        function PhotoCollectionViewModel(data) {
            var self = this;

            self.DESCRIPTION_MAX_WORDS = 32;

            self.commentText = ko.observable('');
            self.properties = data.properties;
            self.collectionClass = data.collectionClass;
            self.collectionOptions = data.collectionOptions;
            self.user = data.user === null ? null : new CollectionPhotoUser(data.user);
            self.count = data.count;
            self.photos = ko.utils.arrayMap(data.initialPhotos, function (photo) {
                return new CollectionPhoto(photo, self);
            });
            self.exitUrl = null;
            if (data.windowOptions !== null)
                ko.utils.extend(self, data.windowOptions);

            self.getIndexById = function (photoId) {
                for (var photo in self.photos)
                    if (self.photos[photo].id == photoId)
                        return parseInt(photo);
            };

            self.currentPhotoIndex = ko.observable(self.getIndexById(data.initialPhotoId));

            self.currentNaturalIndex = ko.observable(data.initialIndex + 1);

            self.currentPhoto = ko.computed(function () {
                return self.photos[self.currentPhotoIndex()];
            });

            self.isFullyLoaded = function () {
                return self.count == self.photos.length;
            };

            self.nextHandler = function () {
                if ((self.currentPhotoIndex() != self.photos.length - 1) || self.isFullyLoaded()) {
                    self.currentPhotoIndex(self.currentPhotoIndex() != self.photos.length - 1 ? self.currentPhotoIndex() + 1 : 0);
                    self.incNaturalIndex(true);
                    self.preloadImages(5, 0);
                    if (! self.isFullyLoaded() && self.currentPhotoIndex() >= self.photos.length - 3)
                        self.preloadMetaNext();

                    self.photoChanged();
                }
            }

            self.prevHandler = function () {
                if ((self.currentPhotoIndex() != 0) || self.isFullyLoaded()) {
                    self.currentPhotoIndex(self.currentPhotoIndex() != 0 ? self.currentPhotoIndex() - 1 : self.photos.length - 1);
                    self.incNaturalIndex(false);
                    self.preloadImages(0, 5);
                    if (! self.isFullyLoaded() && self.currentPhotoIndex() <= 2)
                        self.preloadMetaPrev();

                    self.photoChanged();
                }
            }

            self.photoChanged = function() {
                History.pushState(self.currentPhoto(), self.currentPhoto().title().length > 0 ? self.currentPhoto().title() : self.properties.title + ' - фото ' + self.currentNaturalIndex(), self.currentPhoto().url());
        ga('send', 'pageview', self.currentPhoto().url());
                yaCounter11221648.hit(self.currentPhoto().url());
                self.setLikesPosition();
        $('#photo-window_banner iframe').attr('src', '/direct4.html?' + Math.floor(Math.random() * 9999999999) + 1000000000);
                if (self.collectionClass == 'ContestPhotoCollection')
                    self.loadContestData();

//        setTimeout(function() {
//            adfox_reloadBanner('bn-1');
//        }, 1);
            }

            self.setLikesPosition = function() {
                var likeBottom = ($('.photo-window_img-hold').height() - $('.photo-window_img').height()) / 2 + 30;
                $('.photo-window .like-control').css({'bottom' : likeBottom});
            }

            self.photoWindColH = function() {
                var colCont = $(".photo-window_cont");
                var bannerH = document.getElementById('photo-window_banner').offsetHeight;
                colCont.height($(window).height() - bannerH - 24);
            }

            self.loadContestData = function() {
                $.get('/gallery/default/contestData/', { contestId : self.collectionOptions.contestId, photoId : self.currentPhoto().id }, function(response) {
                    $('.contestData').html(response);
                });
            }

            self.preloadImages = function (nextCount, prevCount) {
                var next = roundSlice(self.photos, self.currentPhotoIndex() + 1, nextCount);
                var prev = roundSlice(self.photos, self.currentPhotoIndex() - 1, -prevCount);
                $.preload(ko.utils.arrayMap(next.concat(prev), function(photo) {
                    return photo.src;
                }), 1);
            }

            self.preloadMetaNext = function () {
                $.get('/gallery/default/preloadNext/', { collectionClass: self.collectionClass, collectionOptions: self.collectionOptions, photoId: self.photos[self.photos.length - 1].id, number: Math.min(self.count - self.photos.length, 10) }, function (response) {
                    for (var p in response.photos)
                        self.photos.push(new CollectionPhoto(response.photos[p], self));
                }, 'json');
            }

            self.preloadMetaPrev = function () {
                $.get('/gallery/default/preloadPrev/', { collectionClass: self.collectionClass, collectionOptions: self.collectionOptions, photoId: self.photos[0].id, number: Math.min(self.count - self.photos.length, 10) }, function (response) {
                    for (var p in response.photos)
                        self.photos.unshift(new CollectionPhoto(response.photos[p], self));
                    self.currentPhotoIndex(self.currentPhotoIndex() + response.photos.length);
                }, 'json');
            }

            self.incNaturalIndex = function (n) {
                var rawIndex = self.currentNaturalIndex() + (n ? 1 : -1);
                var index;
                if (rawIndex == 0)
                    index = data.count;
                else if (rawIndex > data.count)
                    index = 1;
                else
                    index = rawIndex;
                self.currentNaturalIndex(index);
            }

            self.close = function() {
                $(window).off('resize', self.resized);

                if (self.exitUrl === null)
                    PhotoCollectionViewWidget.close();
                else
                    window.location.href = self.exitUrl;
            }

            self.addComment = function() {
                if (self.user !== null)
                    $.post('/ajaxSimple/addComment/', { entity_id : self.currentPhoto().id, entity: 'AlbumPhoto', text: self.commentText() }, function(response) {
                        if (response.status) {
                            self.commentText('');
                            self.currentPhoto().commentsCount(self.currentPhoto().commentsCount() + 1);
                            $('.comments-gray_sent').fadeIn(300, function() {
                                $(this).delay(2000).fadeOut(1000);
                            });
                        }
                    }, 'json');
                else
                    $('[href="#login"]').trigger('click');
            }

            self.resized = function() {
                self.setLikesPosition();
                self.photoWindColH();
            }

            self.currentPhotoIndex.valueHasMutated();
            History.pushState(self.currentPhoto(), self.currentPhoto().title().length > 0 ? self.currentPhoto().title() : self.properties.title + ' - фото ' + self.currentNaturalIndex(), self.currentPhoto().url());
    ga('send', 'pageview', self.currentPhoto().url());
            yaCounter11221648.hit(self.currentPhoto().url());
            self.preloadImages(2, 2);
            setTimeout(function() {
                self.setLikesPosition();
                self.photoWindColH();
                addBaron($('#photo-window .scroll'));
            }, 200);
            if (self.collectionClass == 'ContestPhotoCollection')
                self.loadContestData();

//    (function(bannerPlaceId, requestSrc, defaultLoad){
//        var
//            tgNS = window.ADFOX.RELOAD_CODE,
//            initData = tgNS.initBanner(bannerPlaceId,requestSrc);
//
//        $('#photo-window_banner .display-ib').html(initData.html);
//
//        if(defaultLoad) {
//            tgNS.loadBanner(initData.pr1, requestSrc, initData.sessionId);
//        }
//    })('bn-1', 'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a', true);

            $(window).on('resize', self.resized);
        }

        function CollectionPhoto(data, parent) {
            var self = this;
            self.id = data.id;
            self.title = ko.observable(data.title);
            self.description = ko.observable(data.description);
            self.src = data.src;
            self.date = data.date;
            self.user = new CollectionPhotoUser(data.user);
            self.showFullDescription = ko.observable(false);
            self.likesCount = ko.observable(data.likesCount);
            self.isLiked = ko.observable(data.isLiked);
            self.favourites = ko.observable(new FavouriteWidget({
                modelName: 'AlbumPhoto',
                entity: 'AlbumPhoto',
                modelId:self.id,
                count: data.favourites.count,
                active: data.favourites.active
            }));
            self.views = data.views;
            self.commentsCount = ko.observable(parseInt(data.commentsCount));

            self.toggleShowFullDescription = function () {
                if (self.hasLongDescription())
                    self.showFullDescription(!self.showFullDescription());
            }

            self.hasLongDescription = function () {
                return self.description().split(" ").length > parent.DESCRIPTION_MAX_WORDS;
            }

            self.shortenDescription = function () {
                var array = self.description().split(' ');
                var result = ' ';
                for (var i = 0; i < parent.DESCRIPTION_MAX_WORDS; i++)
                    result += array[i] += ' ';
                return result;
            }

            self.url = function () {
                return parent.properties.url + 'photo' + self.id + '/';
            }

            self.loadComments = function () {
                $.post('/gallery/default/comments/', {id: self.id}, function (response) {
                    $('#js-gallery-comment').html(response);
                });
            }

            self.like = function(data, event){
                $.post('/ajaxSimple/like/', {entity: 'AlbumPhoto', entity_id: self.id}, function (response) {
                    if (response.status) {
                        if (self.isLiked()){
                            self.isLiked(false);
                            self.likesCount(self.likesCount() - 1)
                        }else{
                            self.isLiked(true);
                            self.likesCount(self.likesCount() + 1)
                        }
                    }
                }, 'json');
            }

            self.isEditable = parent.collectionClass == 'PhotoPostPhotoCollection' && parent.user !== null && self.user.id == parent.user.id;

            self.titleBeingEdited = ko.observable(data.title.length == 0);
            self.titleValue = ko.observable(data.title);
            self.saveTitle = function() {
                if (self.titleValue().length > 0)
                    $.post('/gallery/default/updateTitle/', { id : self.id, title : self.titleValue() }, function(response) {
                        if (response.success) {
                            self.title(self.titleValue());
                            self.titleBeingEdited(false);
                        }
                    }, 'json');
            }
            self.editTitle = function() {
                self.titleBeingEdited(true);
            }

            self.descriptionBeingEdited = ko.observable(data.description.length == 0);
            self.descriptionValue = ko.observable(data.description);
            self.saveDescription = function() {
                if (self.descriptionValue().length > 0)
                    $.post('/gallery/default/updateDescription/', { id : self.id, contentId : parent.collectionOptions.contentId, description : self.descriptionValue() }, function(response) {
                        if (response.success) {
                            self.description(self.descriptionValue());
                            self.descriptionBeingEdited(false);
                        }
                    }, 'json');
            }
            self.editDescription = function() {
                self.descriptionBeingEdited(true);
            }

            self.commentsUrl = function() {
                return self.url() + '#comment_list';
            }
        }

        function CollectionPhotoUser(data, parent) {
            var self = this;
            self.id = data.id;
            self.firstName = data.firstName;
            self.lastName = data.lastName;
            self.gender = data.gender;
            self.ava = data.ava;
            self.url = data.url;
            self.avaCssClass = self.gender == 1 ? 'ava__male' : 'ava__female';
            self.fullName = self.firstName + ' ' + self.lastName;
        }

        window.PhotoCollectionViewWidget = {
            originalState : null
        }

        window.PhotoCollectionViewWidget.open = function(collectionClass, collectionOptions, initialPhotoId, windowOptions) {
            initialPhotoId = (typeof initialPhotoId === "undefined") ? null : initialPhotoId;
            windowOptions = (typeof windowOptions === "undefined") ? null : windowOptions;

            $('body').css('overflow', 'hidden');
            this.originalState = History.getState();

            var data = { collectionClass : collectionClass, collectionOptions : collectionOptions, screenWidth : screen.width, useAMD : Boolean(typeof define === 'function' && define['amd']) };
            if (typeof windowOptions !== null)
                data.windowOptions = windowOptions;
            if (initialPhotoId !== null)
                data.initialPhotoId = initialPhotoId;
            $.get('/gallery/default/window/', data, function(response) {
                $('body').append(response);
            });
        }

        window.PhotoCollectionViewWidget.close = function() {
            $('body').css('overflow', 'auto');
            $('#photo-window').remove();
            History.pushState(this.originalState.id, this.originalState.title, this.originalState.url);
        }

        return PhotoCollectionViewModel;
    };
    if (typeof define === 'function' && define['amd']) {
        define('gallery', ['knockout', 'favouriteWidget', 'ko_comments', 'history2', 'preload', 'powertip'], f);
    } else {
        window.PhotoCollectionViewModel = f(window.ko, window.FavouriteWidget);
    }
})(window);