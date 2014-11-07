define(['jquery', 'knockout', 'text!photo-slider/photo-slider.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'models/User', 'photo/PhotoCollection', 'extensions/imagesloaded', 'extensions/PresetManager', 'modules-helpers/component-custom-returner', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, Model, User, PhotoCollection, imagesLoaded, PresetManager) {

    function PhotoSlider(params) {
        var collectionData = {};
        collectionData.id = params.collectionId();
        this.collectionId = params.collectionId;
        this.userId = params.userId;
        this.photoAttach = params.photo;
        this.user = Object.create(User);
        this.current = ko.observable(false);
        this.userInstance = ko.mapping.fromJS({});
        this.userInstance.loading = ko.observable(true);
        this.collection = new PhotoCollection(collectionData);
        this.collection.usablePreset = ko.observable('sliderPhoto');
        this.userHandler = function userHandler(user) {
            if (user.success === true) {
                ko.mapping.fromJS(this.user.init(user.data), this.userInstance);
                this.userInstance.loading(false);
            }
        };
        this.getUser = function getUser() {
            Model
                .get(this.user.getUserUrl, {id: this.userId, avatarSize: 40})
                .done(this.userHandler.bind(this));
        };
        this.getCollection = function getCollection() {
            this.collection.getCollectionCount(this.collection.id());
        };
        this.collection.attachesCount.subscribe(function (value) {
            if (value > 0) {
                this.collection.loadImage('progress', '.photo-window_img-hold', '.photo-window_img-hold');
            }
        }, this);
        this.lookForStart = function lookForStart(newAttaches) {
            this.current(Model.findByIdObservableIndex(this.photoAttach().id(), this.collection.attaches()));
            window.history.pushState(null, 'Фотоальбом', this.current().element().url());
            this.imgTag = ko.computed(function () {
                return '<img src="' + this.current().element().photo().getGeneratedPreset('sliderPhoto') + '" data-id="' + this.current().element().id() + '" class="photo-window_img">';
            }, this);
        };
        this.next = function next() {
            var oldIndex = this.current().index();
            this.current().index(oldIndex + 1);
            this.current().element(this.collection.attaches()[this.current().index()]);
            window.history.pushState(null, 'Фотоальбом', this.current().element().url());
            this.collection.loadImage('progress', '.photo-window_img-hold', '.photo-window_img-hold');
        };
        this.prev = function prev() {
            var oldIndex = this.current().index();
            this.current().index(oldIndex - 1);
            this.current().element(this.collection.attaches()[this.current().index()]);
            window.history.pushState(null, 'Фотоальбом', this.current().element().url());
            this.collection.loadImage('progress', '.photo-window_img-hold', '.photo-window_img-hold');
        };
        this.collection.attaches.subscribe(this.lookForStart.bind(this));
        this.initializeSlider = function initializeSlider() {
            this.collection.getPartsCollection(this.collection.id(), 0, null);
            this.getUser();
            this.getCollection();
        };
        this.initializeSlider();

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