define(['jquery', 'knockout', 'models/Photopost', 'models/Model', 'photo/PhotoCollection', 'extensions/adhistory', 'text!post-photo-view/post-photo-view.html', 'knockout.mapping', 'extensions/sliderBinding'], function postPhotoViewHandler($, ko, Photopost, Model, PhotoCollection, AdHistory, template) {
    function PostPhotoView(params) {
        this.photopost = Object.create(Photopost);
        this.collection = new PhotoCollection({});
        this.title = '';
        this.description = '';
        this.current = ko.observable(false);
        this.userInstance = ko.mapping.fromJS({});
        this.userInstance.loading = ko.observable(true);
        this.imgTag = ko.observable('');
        this.masterUrl = location.href;
        this.masterTitle = document.title;
        this.collection.usablePreset = ko.observable('myPhotosPreview');
        this.setDelay = 1000;
        this.currentId = ko.observable();
        this.photoLength = 20;
        this.offsetMinimal = 5;
        this.photoAttach = (ko.isObservable(params.photo) === false) ? ko.observable(params.photo) : params.photo().id;
        this.returnNewColor = Model.returnNewColor;
        this.colorsArray = Model.colorsArray;
        this.elementCssClass = 'b-album_prev-li img-grid_loading__';

        /**
         * imgBinding
         */
        this.addImageBinding = function addImageBinding() {
            this.imgTag('<img src="' + this.current().element().photo().getGeneratedPreset('postCollectionCover') + '" data-id="' + this.current().element().id() + '" class="b-album_img-big">');
            this.collection.loadImage('progress', '.b-album_img-picture', '.b-album_img-picture');
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
                sliderDfd.then(this.initStartingPoint.bind(this)).done(this.addImageBinding.bind(this));
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
            if (this.current().index() === 0) {
                AdHistory.pushState(null, title, this.photopost.url());
            }
            AdHistory.bannerInit(this.photopost.url());
            return this.current();
        };
        /**
         * Same actions on manipulating slider
         */
        this.sliderManipulations = function sliderManipulations(currentArgument) {
            var title = this.creatingTitle(this.current());
            this.current().element(this.collection.attaches()[this.current().index()]);
            AdHistory.pushState(null, title, this.photopost.url() + this.current().element().url());
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
         * keypressTest - влево, вправо, выход
         *
         * @param  obj data  description
         * @param  object event description
         * @return
         */
        this.keypressTest = function keypressTest(event) {
            var prop = Keyboard.onHandler(event, Keyboard.sliderKeys);
            if (prop === 'right' || prop === 'space') {
                this.next();
            }
            if (prop === 'left') {
                this.prev();
            }
        };
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
                this.collection.getSliderCollection(this.photopost.collectionId(), this.calculateOffset(receivedData.data.index), this.photoLength);
            }
        };

        this.retrieveCollectionMeta = function retrieveCollectionMeta(collectionMeta) {
            if (collectionMeta.success === true) {
                this.collection.id(collectionMeta.data.id);
                this.collection.attachesCount(collectionMeta.data.attachesCount);
                this.collection.cover(collectionMeta.data.cover);
            }
        };
        this.getCollection = function getCollection(collectionId) {
            this.collection.get(collectionId).done(this.retrieveCollectionMeta.bind(this));
        };

        /**
         * Init photosl
         */
        this.initializePhotoSlider = function initializePhotoSlider() {
            Model.get(this.collection.getAttachUrl, { id: this.photoAttach() }).done(this.observeAttach.bind(this));
            this.getCollection(this.photopost.collectionId());
        };


        this.handlePhotopost = function handlePhotopost(response) {
            if (response.success === true) {
                this.photopost.init(response.data);
                this.initializePhotoSlider();
            }
        };
        if (params.id) {
            this.photopost.get(params.id).done(this.handlePhotopost.bind(this));
        }
    }

    return {
        viewModel: PostPhotoView,
        template: template
    };
});
