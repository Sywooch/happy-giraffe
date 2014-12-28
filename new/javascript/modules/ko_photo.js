define('ko_photoUpload', ['knockout', 'knockout.mapping', 'photo/Photo', 'photo/PhotoAttach', 'photo/PhotoAlbum', 'user-config', 'bootstrap', 'jquery_file_upload', 'jquery.ui', 'photo/bindings/thumb', 'photo/bindings/photoUpload'], function(ko, mapping, Photo, PhotoAttach, PhotoAlbum, userConfig) {


    // Биндинг для плагина jQuery File Upload
    ko.bindingHandlers.fileUpload = {
        update: function (element, valueAccessor) {
            var options = valueAccessor() || {};

            $(element).fileupload(options);

            if (options.hasOwnProperty('dropZone')) {
                var dropZone = $(options.dropZone);
                dropZone.on('dragover', function() {
                    dropZone.addClass('dragover');
                });
                dropZone.on('dragleave', function() {
                    dropZone.removeClass('dragover');
                });
            }

        }
    };

    // Биндинг слайдера
    ko.bindingHandlers.slider = {
        init: function (element, valueAccessor, allBindingsAccessor) {
            var options = allBindingsAccessor().sliderOptions || {};
            $(element).slider(options);
            ko.utils.registerEventHandler(element, "slidechange", function (event, ui) {
                var observable = valueAccessor();
                observable(ui.value);
            });
            ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
                $(element).slider("destroy");
            });
            ko.utils.registerEventHandler(element, "slide", function (event, ui) {
                var observable = valueAccessor();
                observable(ui.value);
            });
        },
        update: function (element, valueAccessor) {
            var value = ko.utils.unwrapObservable(valueAccessor());
            if (isNaN(value)) value = 0;
            $(element).slider("value", value);
        }
    };



    // Основная модель вставки фотографий
    function PhotoAddViewModel(data) {
        var self = this;

        self.collectionId = data.form.collectionId;
        self.multiple = data.form.multiple;
        self.photos = ko.observableArray([]);
        self.photo = ko.computed({
            read: function () {
                return self.photos().length > 0 ? self.photos()[0] : null;
            },
            write: function (value) {
                if (self.photo() !== null) {
                    self.removePhotoInternal(self.photo());
                }
                self.photos.push(value);
            }
        });

        self.added = function(photo) {
            if (self.multiple) {
                self.photos.push(photo);
            } else {
                self.photo(photo);
            }
        }

        self.photoIds = function() {
            return ko.utils.arrayMap(self.photos(), function(photo) {
                return attach.photo.id();
            });
        }

        self.removePhoto = function(photo) {
            self.removePhotoInternal(photo);
        }
    }
    PhotoAddViewModel.prototype.add = function() {
        var self = this;
        if (self.multiple) {
            ko.utils.arrayForEach(self.photos(), function(photo) {
                ko.bindingHandlers.photoComponentUpload.callback(photo);
            });
        } else {
            ko.bindingHandlers.photoComponentUpload.callback(self.photo());
        }
    };
    PhotoAddViewModel.prototype.removePhotoInternal = function(photo) {
        var self = this;
        self.photos.remove(photo);
    };

    // Основная модель загрузки фото
    function PhotoUploadViewModel(data) {
        var self = this;
        PhotoAddViewModel.apply(self, arguments);

        self.loadingPhotos = ko.computed(function() {
            return ko.utils.arrayFilter(self.photos(), function(photo) {
                return photo.status() == PhotoUpload.prototype.STATUS_LOADING;
            });
        });

        self.successPhotos = ko.computed(function() {
            return ko.utils.arrayFilter(self.photos(), function(photo) {
                return photo.status() == PhotoUpload.prototype.STATUS_SUCCESS;
            });
        });

        self.loading = ko.computed(function() {
            return self.loadingPhotos().length > 0;
        });

        self.processResponse = function(photo, response) {
            if (response.success) {
                ko.mapping.fromJS((response.data.attach || response.data.photo), {}, photo);
                photo.status(PhotoUpload.prototype.STATUS_SUCCESS);
                $(function($){
                    var api;
                    $('#jcrop_target').Jcrop({
                        // start off with jcrop-light class
                        bgOpacity: 0.3,
                        bgColor: '#fff',
                        aspectRatio: 1,
                        boxWidth: 450,
                        addClass: 'jcrop-circle'
                    },function(){
                        api = this;
                        api.setSelect([50,50,400,400]);
                        api.setOptions({ bgFade: true });
                        api.ui.selection.addClass('jcrop-selection');
                    });
                });
            } else {
                photo.error(response.error);
                photo.status(PhotoUpload.prototype.STATUS_FAIL);
            }
        }
    }
    PhotoUploadViewModel.prototype = Object.create(PhotoAddViewModel.prototype);
    PhotoUploadViewModel.prototype.add = function() {
        var self = this;
        // $.post('/api/photo/collections/addPhotos/', JSON.stringify({ collectionId : self.collectionId, photosIds : self.photoIds() }), function(response) {
        //    if (response.success) {
        //        PhotoAddViewModel.prototype.add.call(self);
        //    }
        // }, 'json');
        PhotoAddViewModel.prototype.add.call(self);
        //Только для редактора
        // PhotoAddViewModel.prototype.add.call(self);
    };
    PhotoUploadViewModel.prototype.removePhotoInternal = function(photo) {
        var self = this;
        if (photo.status() == PhotoUpload.prototype.STATUS_LOADING) {
            photo.jqXHR.abort();
        }
        PhotoAddViewModel.prototype.removePhotoInternal.call(self, photo);
    };


    // Mixin, общие методы для двух форм загрузки с компьютера
    function asFromComputer() {
        this.populatePhoto = function(data, response) {
            var jqXHR = data.submit();
            return new PhotoUpload({ originalname : data.files[0].name }, jqXHR, this);
        }

        this.fileUploadSettings = {
            dataType: 'json',
            url: '/api/photo/photos/uploadFromComputer/'
        };
    }

    // Модель одиночной загрузки файла с компьютера
    function FromComputerSingleViewModel(data) {
        var self = this;
        PhotoUploadViewModel.apply(self, arguments);
        $.extend(self.fileUploadSettings, {
            add: function (e, data) {
                if (self.collectionId !== undefined) {
                    data.formData = {
                        collectionId: self.collectionId
                    };
                }
                self.added(self.populatePhoto(data));
            },
            done: function (e, data) {
                self.photo().file = data.files[0];
                self.processResponse(self.photo(), data.result);
            },
            fail: function(e, data) {
                if (data.errorThrown != 'abort') {
                    self.photo().status(PhotoUpload.prototype.STATUS_FAIL);
                }
            }
        });
    }
    FromComputerSingleViewModel.prototype = Object.create(PhotoUploadViewModel.prototype);
    asFromComputer.call(FromComputerSingleViewModel.prototype);


    // Модель одиночной загрузки файла с компьютера
    function AvatarSingleViewModel(data) {
        var self = this;
        PhotoUploadViewModel.apply(self, arguments);
        $.extend(self.fileUploadSettings, {
            add: function (e, data) {
                if (self.collectionId !== undefined) {
                    data.formData = {
                        collectionId: self.collectionId
                    };
                }
                self.added(self.populatePhoto(data));
            },
            done: function (e, data) {
                self.photo().file = data.files[0];
                self.processResponse(self.photo(), data.result);
            },
            fail: function(e, data) {
                if (data.errorThrown != 'abort') {
                    self.photo().status(PhotoUpload.prototype.STATUS_FAIL);
                }
            }
        });
    }
    AvatarSingleViewModel.prototype = Object.create(PhotoUploadViewModel.prototype);
    asFromComputer.call(AvatarSingleViewModel.prototype);

    // Модель множественной загрузки с компьютера
    function FromComputerMultipleViewModel(data) {
        var self = this;
        self.collectionId = data.form.collectionId;
        PhotoUploadViewModel.apply(self, arguments);

        self.findPhotoByRequest = function(request) {
            return ko.utils.arrayFirst(self.photos(), function (photo) {
                return photo.jqXHR == request;
            });
        };

        self.cancelAll = function()
        {
            ko.utils.arrayForEach(self.loadingPhotos(), function(photo) {
                self.removePhotoInternal(photo);
            });
        }

        $.extend(self.fileUploadSettings, {
            dropZone: '.popup-add_frame__multi',
            sequentialUploads: true,
            add: function (e, data) {
                data.formData = {
                    collectionId: self.collectionId
                };
                if (self.photos().length < 300) {
                    self.added(self.populatePhoto(data));
                }
            },
            done: function (e, data) {
                var photo = self.loadingPhotos()[0];
                self.processResponse(photo, data.result);
            },
            fail: function(e, data) {
                var photo = self.loadingPhotos()[0];
                if (data.errorThrown != 'abort') {
                    photo.status(PhotoUpload.prototype.STATUS_FAIL);
                }
            }
        });

        // self.fileUploadSettings.data.collectionId = data.form.collectionId;

        self.fileUploadSettingsMore = $.extend({}, self.fileUploadSettings);
        self.fileUploadSettingsMore.dropZone = null;
    }
    FromComputerMultipleViewModel.prototype = Object.create(PhotoUploadViewModel.prototype);
    asFromComputer.call(FromComputerMultipleViewModel.prototype);

    // Модель загрузки по URL
    function ByUrlViewModel(urlData) {
        var self = this;
        PhotoUploadViewModel.apply(self, arguments);

        self.url = ko.observable('');
        self.throttledUrl = ko.computed(self.url).extend({ throttle: 400 });

        self.throttledUrl.subscribe(function(val) {
            if (val.length > 0) {
                self.added(new PhotoUpload({}, self));

                self.photo().jqXHR = $.ajax({
                    url: '/api/photo/photos/uploadByUrl/',
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        url : val,
                        collectionId: self.collectionId
                    }),
                    success: function(data) {
                        self.processResponse(self.photo(), data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (errorThrown != 'abort') {
                            self.photo().status(PhotoUpload.prototype.STATUS_FAIL);
                        }
                    }
                });
            } else {

            }
        });
    }
    ByUrlViewModel.prototype = Object.create(PhotoUploadViewModel.prototype);
    ByUrlViewModel.prototype.removePhotoInternal = function(photo) {
        var self = this;
        self.url('');
        PhotoUploadViewModel.prototype.removePhotoInternal.call(self, photo);
    }

    // Модель фотографии в рамках функционала загрузки фото
    // Модель фотографии в рамках функционала загрузки фото
    function PhotoUpload(data, jqXHR, parent) {
        var self = this;
        Photo.apply(self, arguments);

        self.jqXHR = jqXHR;
        self.status = ko.observable(PhotoUpload.prototype.STATUS_LOADING);
        self.error = ko.observable();

        self.rotateLeft = function() {
            self.rotate(false);
        };

        self.rotateRight = function() {
            self.rotate(true);
        };

        self.rotate = function(clockwise) {
            $.post('/api/photo/photos/rotate/', JSON.stringify({ clockwise : clockwise, photoId : self.id() }), function(response) {
                if (response.success) {
                    ko.mapping.fromJS(response.data, {}, self);
                }
            }, 'json');
        };

        self.cssClass = ko.computed(function() {
            switch (self.status()) {
                case PhotoUpload.prototype.STATUS_LOADING:
                    return 'i-photo__load';
                case PhotoUpload.prototype.STATUS_SUCCESS:
                    return 'i-photo__loaded';
                case PhotoUpload.prototype.STATUS_FAIL:
                    return 'i-photo__error';
            }
        });
    }
    PhotoUpload.prototype.STATUS_LOADING = 0;
    PhotoUpload.prototype.STATUS_SUCCESS = 1;
    PhotoUpload.prototype.STATUS_FAIL = 2;

    function FromAlbumsPhotoAttach(data, parent) {
        var self = this;
        PhotoAttach.apply(self, arguments);
        self.isActive = ko.computed(function() {
            return parent.photos().indexOf(self.photo()) != -1;
        });
    }

    // Модель вставки из альбомов
    function FromAlbumsViewModel(data) {
        var self = this;
        PhotoAddViewModel.apply(self, arguments);

        self.albums = ko.observableArray();

        self.applyAlbums = function (albums) {
            if (albums.success === true) {
                self.albums(ko.utils.arrayMap(albums.data.albums, function(album) {
                    var pAlbumInstance = Object.create(PhotoAlbum);
                    pAlbumInstance.init(album);
                    return pAlbumInstance;
                }));
            }
        };

        self.currentAlbum = ko.observable(null);
        self.thumbsSize = ko.observable(2);

        self.updateThumbsSize = function(diff) {
            self.thumbsSize(self.thumbsSize() + diff);
        };

        self.thumbsSizeClass = ko.computed(function() {
            switch (self.thumbsSize()) {
                case 1:
                    return 'album-preview__s';
                case 2:
                    return 'album-preview__m';
                case 3:
                    return 'album-preview__xl';
            }
        });

        self.thumbsPreset = ko.computed(function() {
            switch (self.thumbsSize()) {
                case 1:
                case 2:
                    return 'uploadPreview';
                case 3:
                    return 'uploadPreviewBig';
            }
        });
        PhotoAlbum.get(userConfig.userId, true, self.applyAlbums);


        self.unselectAlbum = function() {
            self.currentAlbum(null);
        };

        self.selectAlbum = function(album) {
            $.post('/api/photo/collections/getAttaches/', JSON.stringify({ collectionId : album.photoCollection().id(), offset: 0 }), function(response) {
                album.photoCollection().usablePreset = 'uploadPreview';
                album.photoCollection().attaches(ko.utils.arrayMap(response.data.attaches, function(attach) {
                    var photoAttach = new FromAlbumsPhotoAttach(attach, self);
                    return photoAttach;
                }));
                self.currentAlbum(album);

            }, 'json');
        };

        self.selectAttach = function(attach) {
            if (attach.isActive()) {
                self.removePhoto(attach.photo());
            } else {
                self.added(attach.photo());
            }
        };

        self.hint = ko.computed(function() {
            if (self.photos().length > 0) {
                return 'Выбрано: ' + self.photos().length;
            } else {
                return 'Выберите фото';
            }
        });
    }
    FromAlbumsViewModel.prototype = Object.create(PhotoAddViewModel.prototype);

    return {
        FromComputerSingleViewModel: FromComputerSingleViewModel,
        FromComputerMultipleViewModel: FromComputerMultipleViewModel,
        FromAlbumsViewModel: FromAlbumsViewModel,
        ByUrlViewModel: ByUrlViewModel,
        AvatarSingleViewModel: AvatarSingleViewModel
    };
});