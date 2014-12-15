define(['jquery', 'knockout', 'text!photo-slider/photo-slider.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'models/User', 'photo/PhotoCollection', 'extensions/imagesloaded', 'extensions/PresetManager', 'extensions/adhistory', 'ads-config', 'modules-helpers/component-custom-returner', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, Model, User, PhotoCollection, imagesLoaded, PresetManager, AdHistory, adsConfig) {

    function PhotoSlider(params) {
        var collectionData = {};
        collectionData.id = (ko.isObservable(params.collectionId) === false) ? params.collectionId : params.collectionId();
        this.collectionId = params.collectionId;
        this.userSliderId = params.userId || User.userId;
        this.photoAttach = (ko.isObservable(params.photo) === false) ? ko.observable(params.photo) : params.photo().id;
        this.title = params.title;
        this.description = params.description;
        this.user = Object.create(User);
        this.current = ko.observable(false);
        this.userInstance = ko.mapping.fromJS({});
        this.userInstance.loading = ko.observable(true);
        this.imgTag = ko.observable('');
        this.collection = new PhotoCollection(collectionData);
        this.masterUrl = location.href;
        this.masterTitle = document.title;
        this.collection.usablePreset = ko.observable('sliderPhoto');
        this.setDelay = 1000;
        this.tagName = 'photo-slider';
        this.currentId = ko.observable();
        /**
         * getting User
         * @param user
         */
        this.userHandler = function userHandler(user) {
            if (user.success === true) {
                ko.mapping.fromJS(this.user.init(user.data), this.userInstance);
                this.userInstance.loading(false);
            }
        };
        /**
         * Particular get method
         */
        this.getUser = function getUser() {
            Model
                .get(this.user.getUserUrl, {id: this.userSliderId, avatarSize: 40})
                .done(this.userHandler.bind(this));
        };
        /**
         * Getting collection
         */
        this.getCollection = function getCollection() {
            this.collection.getCollectionCount(this.collection.id());
        };
        /**
         * imgBinding
         */
        this.addImageBinding = function addImageBinding() {
            this.imgTag('<img src="' + this.current().element().photo().getGeneratedPreset('sliderPhoto') + '" data-id="' + this.current().element().id() + '" class="photo-window_img">');
            this.collection.loadImage('progress', '.photo-window_img-hold', '.photo-window_img-hold');
        };
        /**
         * Начало
         * @param newAttaches
         */
        this.lookForStart = function lookForStart(newAttaches) {
            var title;
            this.current(Model.findByIdObservableIndex(this.photoAttach(), this.collection.attaches()));
            title = (this.current().element().photo().title() !== "") ? this.current().element().photo().title() : (this.current().index() + 1);
            this.currentId(this.current().element().id());
            AdHistory.pushState(null, title, this.current().element().url());
            //FCUK quick fix
            setTimeout(this.addImageBinding.bind(this), this.setDelay);
            //---FCUK quick fix
        };
        /**
         * Next slide
         */
        this.next = function next() {
            if ((this.current().index() + 1) !== this.collection.attachesCount()) {
                var oldIndex = this.current().index(),
                    title = (this.current().element().photo().title() !== "") ? this.current().element().photo().title() : (this.current().index() + 1);
                this.current().index(oldIndex + 1);
                this.current().element(this.collection.attaches()[this.current().index()]);
                AdHistory.pushState(null, title, this.current().element().url());
                this.addImageBinding();
                this.photoChange();
            }
        };
        /**
         * Prev Slide
         */
        this.prev = function prev() {
            if ((this.current().index() + 1) > 1) {
                var oldIndex = this.current().index(),
                    title = (this.current().element().photo().title() !== "") ? this.current().element().photo().title() : (this.current().index() + 1);
                this.current().index(oldIndex - 1);
                this.current().element(this.collection.attaches()[this.current().index()]);
                AdHistory.pushState(null, title, this.current().element().url());
                this.addImageBinding();
                this.photoChange();
            }

        };
        this.collection.attaches.subscribe(this.lookForStart.bind(this));
        /**
         * Event on photo change
         */
        this.photoChange = function photoChange() {
            if (adsConfig.showAds === true) {
                dataLayer.push({'event': 'virtualView'});
                yaCounter11221648.hit(self.currentPhoto().url());
                adfox_reloadBanner('bn-1');
            }
        };
        this.bannerInit = function bannerInit() {
            if (adsConfig.showAds === true) {
                (function (bannerPlaceId, requestSrc, defaultLoad) {
                    var
                        tgNS = window.ADFOX.RELOAD_CODE,
                        initData = tgNS.initBanner(bannerPlaceId, requestSrc);

                    $('#photo-window_banner .display-ib').html(initData.html);

                    if (defaultLoad) {
                        tgNS.loadBanner(initData.pr1, requestSrc, initData.sessionId);
                    }
                })('bn-1', 'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a', true);
            };
        };
        /**
         * Init slider
         */
        this.initializeSlider = function initializeSlider() {
            this.collection.getPartsCollection(this.collection.id(), 0, null);
            if (this.userSliderId) {
                this.getUser();
            }
            this.getCollection();
            this.bannerInit();
        };
        this.initializeSlider();
        /**
         * close handler
         */
        this.closePhotoHandler = function closePhotoHandler(Parent) {
            if (!$.isPlainObject(Parent)) {
                Parent.closePhotoHandler(Parent);
            } else {
                $(this.tagName).remove();
            }
            AdHistory.pushState(null, this.masterTitle, this.masterUrl);
        };

        /**
         * Shitty jqcode
         */
        /* Height block comment scroll in photo-window */
        function photoWindColH () {
            var colCont = $(".photo-window_cont");
            //var bannerH = document.getElementById('photo-window_banner').offsetHeight;
            colCont.height($(window).height() - 24);
        };
        $(document).ready(function () {
            photoWindColH();
            /* custom scroll */
            var scroll = $('.scroll').baron({
                scroller: '.scroll_scroller',
                barOnCls: 'scroll__on',
                container: '.scroll_cont',
                track: '.scroll_bar-hold',
                bar: '.scroll_bar'
            });
        });
        $(window).resize(function () {
            photoWindColH();
        });
    };

    return {
        viewModel: PhotoSlider,
        template: template
    };

});