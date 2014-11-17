define(['jquery', 'knockout', 'text!photo-slider/photo-slider.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'models/User', 'photo/PhotoCollection', 'extensions/imagesloaded', 'extensions/PresetManager', 'extensions/adhistory', 'modules-helpers/component-custom-returner', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, Model, User, PhotoCollection, imagesLoaded, PresetManager, AdHistory) {

    function PhotoSlider(params) {
        var collectionData = {};
        collectionData.id = params.collectionId();
        this.collectionId = params.collectionId;
        this.userSliderId = params.userId;
        this.photoAttach = params.photo;
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
            this.current(Model.findByIdObservableIndex(this.photoAttach().id(), this.collection.attaches()));
            AdHistory.pushState(null, 'Фотоальбом', this.current().element().url());
            //FCUK quick fix
            setTimeout(this.addImageBinding.bind(this), this.setDelay);
            //---FCUK quick fix
        };
        /**
         * Next slide
         */
        this.next = function next() {
            var oldIndex = this.current().index();
            this.current().index(oldIndex + 1);
            this.current().element(this.collection.attaches()[this.current().index()]);
            AdHistory.pushState(null, 'Фотоальбом', this.current().element().url());
            this.addImageBinding();
        };
        /**
         * Prev Slide
         */
        this.prev = function prev() {
            var oldIndex = this.current().index();
            this.current().index(oldIndex - 1);
            this.current().element(this.collection.attaches()[this.current().index()]);
            AdHistory.pushState(null, 'Фотоальбом', this.current().element().url());
            this.addImageBinding();
        };
        this.collection.attaches.subscribe(this.lookForStart.bind(this));
        /**
         * Init slider
         */
        this.initializeSlider = function initializeSlider() {
            this.collection.getPartsCollection(this.collection.id(), 0, null);
            this.getUser();
            this.getCollection();
        };
        this.initializeSlider();
        /**
         * close handler
         */
        this.closePhotoHandler = function closePhotoHandler(Parent) {
            Parent.closePhotoHandler(Parent);
            AdHistory.pushState(null, this.masterTitle, this.masterUrl);
        };
        /**
         * Shitty jqcode
         */
        /* Height block comment scroll in photo-window */
        function photoWindColH () {
            var colCont = $(".photo-window_cont");
            var bannerH = document.getElementById('photo-window_banner').offsetHeight;
            colCont.height($(window).height() - bannerH - 24);
        }
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