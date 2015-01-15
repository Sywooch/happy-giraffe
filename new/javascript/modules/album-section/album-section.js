define(['knockout', 'text!album-section/album-section.html', 'models/Model', 'models/User', 'photo/PhotoAlbum', 'extensions/sliderBinding'], function AlbumSectionHandler(ko, template, Model, User, PhotoAlbum) {
    function AlbumSection(params) {
        this.randomAlbum = params.randomAlbum;
        if (params.userId === undefined) {
            this.userId = User.userId;
        } else {
            this.userId = params.userId;
        }
        this.photoAlbum = Object.create(PhotoAlbum);
        this.allPhotoCount = ko.observable(params.count);
        this.loaded = ko.observable(false);
        this.photoAlbum.usablePreset = 'myPhotosPreview';
        this.colorsArray = Model.colorsArray;
        this.returnNewColor = Model.returnNewColor;
        this.rightForManipulation = Model.checkRights(this.userId);
        this.albumCreationUrl = '/user/' + this.userId + '/albums/create/';
        this.albumUrl = '/user/' + this.userId + '/albums/';
        this.photoAlbum.pageCount = 4;
        this.fillCount = function fillCount(getObj) {
            if (getObj.success === true) {
                if (getObj.data.hasOwnProperty('all')) {
                    this.allPhotoCount(getObj.data.all.attachesCount);
                }
            }
        };
        this.getPhotoAlbum = function getPhotoAlbum(passedData) {
            var album;
            if (passedData.success === true) {
                album = this.photoAlbum.findById(this.randomAlbum, passedData.data.albums);
                if (album) {
                    this.photoAlbum.init(album);
                    if (this.allPhotoCount() === undefined) {
                        Model.get('/api/photo/collections/getByUser/', { userId: this.userId }).done(this.fillCount.bind(this));
                    }
                }
            }
            this.loaded(true);
        };
        if (this.userId !== null) {
            this.photoAlbum.get(this.userId, false, this.getPhotoAlbum.bind(this));
        }
    }
    return {
        viewModel: AlbumSection,
        template: template
    };
});