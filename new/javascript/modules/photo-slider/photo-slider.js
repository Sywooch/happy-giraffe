define(['jquery', 'knockout', 'text!photo-slider/photo-slider.html', 'photo/PhotoAlbum', 'user-config', 'models/Model', 'models/User', 'photo/PhotoCollection', 'extensions/imagesloaded', 'extensions/PresetManager', 'extensions/adhistory', 'modules-helpers/component-custom-returner', 'bootstrap', 'ko_photoUpload', 'ko_library', 'extensions/knockout.validation', 'ko_library'], function ($, ko, template, PhotoAlbum, userConfig, Model, User, PhotoCollection, imagesLoaded, PresetManager, AdHistory) {

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
        this.photoLength = 20;
        this.offsetMinimal = 5;
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
         * retrieve collection meta data
         * @param collectionMeta
         */
        this.retrieveCollectionMeta = function retrieveCollectionMeta(collectionMeta) {
            if (collectionMeta.success === true) {
                this.collection.attachesCount(collectionMeta.data.attachesCount);
                this.collection.cover(collectionMeta.data.cover);
            }
        };
        /**
         * Getting collection
         */
        this.getCollection = function getCollection() {
            this.collection.get(this.collection.id()).done(this.retrieveCollectionMeta.bind(this));
        };
        /**
         * imgBinding
         */
        this.addImageBinding = function addImageBinding() {
            this.imgTag('<img src="' + this.current().element().photo().getGeneratedPreset('sliderPhoto') + '" data-id="' + this.current().element().id() + '" class="photo-window_img">');
            this.collection.loadImage('progress', '.photo-window_img-hold', '.photo-window_img-hold');
        };
        /**
         * Creating title for photo
         * @param currentElement
         * @returns {*}
         */
        this.creatingTitle = function creatingTitle(currentElement) {
            return (currentElement.element().photo().title() !== "") ? currentElement.element().photo().title() : (currentElement.element().index() + 1);
        };
        /**
         * Начало
         * @param newAttaches
         */
        this.lookForStart = function lookForStart() {
            var title;
            if (this.current().element === undefined) {
                var sliderDfd = $.Deferred();
                sliderDfd
                  .then(this.initStartingPoint.bind(this))
                  .done(this.addImageBinding.bind(this));
                sliderDfd.resolve(Model.findByIdObservableIndex(this.photoAttach(), this.collection.attaches()));
            } else {
                this.current(Model.findByIdObservableIndex(this.current().element().id(), this.collection.attaches()));
            }
        };
        /**
         * initStartingPoint
         *
         * @return {type}  description
         */
        this.initStartingPoint = function initStartingPoint(currentArgument) {
            this.current(currentArgument);
            title = this.creatingTitle(this.current());
            this.currentId(this.current().element().id());
            AdHistory.pushState(null, title, this.current().element().url());
            AdHistory.bannerInit(this.current().element().url());
            return this.current();
        };
        /**
         * Same actions on manipulating slider
         */
        this.sliderManipulations = function sliderManipulations(currentArgument) {
            var title = this.creatingTitle(this.current());
            this.current().element(this.collection.attaches()[this.current().index()]);
            AdHistory.pushState(null, title, this.current().element().url());
            AdHistory.reloadBanner();
            this.addImageBinding();
        };

        /**
         * sliderManipulationsMoving
         *
         * @return {type}  description
         */
        this.sliderManipulationsMoving = function sliderManipulationsMoving() {
            this.sliderManipulations(this.collection.attaches()[this.current().index()]);
        };
        /**
         * load more pictures
         * @param positon
         * @param index
         */
        this.needMorePictures = function needMorePictures(position, index) {
            if ((position + this.offsetMinimal) !== this.collection.attachesCount() && (position - this.offsetMinimal) !== 0 && this.collection.attachesCount() !== this.collection.attaches().length) {
                if ((index + this.offsetMinimal) === this.collection.attaches().length) {
                    this.collection.getSliderCollection(this.collection.id(), this.calculatePostOffset(position, false), this.photoLength);
                }
                if ((index - this.offsetMinimal) === 0) {
                    this.collection.getSliderCollection(this.collection.id(), this.calculatePostOffset(position, true), this.photoLength);
                }
            }
        };
        /**
         * Next slide
         */
        this.next = function next() {
            var position = this.current().element().index() + 1,
                index = this.current().index();
            if (position !== this.collection.attachesCount()) {
                this.current().index(index + 1);
                this.sliderManipulationsMoving();
                this.needMorePictures(this.current().element().index(), this.current().index());
            }
        };
        /**
         * Prev Slide
         */
        this.prev = function prev() {
            var position = this.current().element().index() + 1,
                index = this.current().index();
            if (position > 1) {
                this.current().index(index - 1);
                this.sliderManipulationsMoving();
                this.needMorePictures(this.current().element().index(), this.current().index());
            }
        };
        this.collection.attaches.subscribe(this.lookForStart.bind(this));
        /**
         * Calculating post offset
         * @param position
         * @returns {number}
         */
        this.calculatePostOffset = function calculatePostOffset(position, left) {
            var calculates;
            if (left) {
                calculates = position - this.photoLength;
                return calculates >= 0 ? calculates : 0;
            }
            calculates = position + this.offsetMinimal;
            return calculates;
        };
        /**
         * Calculating starting offset
         * @param position
         * @returns {number}
         */
        this.calculateOffset = function calculateOffset(position) {
            var splitted = this.photoLength / 2,
                calculated;
            if (position <= splitted) {
                return 0;
            }
            return position - splitted;
        };
        /**
         * receiving attaches
         * @param receivedData
         */
        this.observeAttach = function observeAttach(receivedData) {
            if (receivedData.success === true) {
                this.collection.getSliderCollection(this.collection.id(), this.calculateOffset(receivedData.data.index), this.photoLength);
            }
        };
        /**
         * Init slider
         */
        this.initializeSlider = function initializeSlider() {
            Model.get(this.collection.getAttachUrl, { id: this.photoAttach() }).done(this.observeAttach.bind(this));
            if (this.userSliderId) {
                this.getUser();
            }
            this.getCollection();
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
