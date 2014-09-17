define('ko_photo', ['knockout'], function(ko) {


    function PresetManager() {
        var self = this;

        self.presets = {"uploadPreview":{"filter":"lepilla","width":155,"height":140},"uploadPreviewBig":{"filter":"lepilla","width":325,"height":295},"uploadAlbumCover":{"filter":"lepilla","width":205,"height":140},"rowGrid":{"filter":"relativeResize","method":"heighten","parameter":200},"myPhotosAlbumCover":{"filter":"lepilla","width":880,"height":580},"myPhotosPreview":{"filter":"relativeResize","method":"heighten","parameter":70}};

        self.filters = {
            lepilla: {
                getWidth: function(imageWidth, imageHeight, presetConfig) {
                    var imageRatio = imageWidth / imageHeight;
                    var presetRatio = presetConfig.width / presetConfig.height;
                    if (imageRatio >= presetRatio) {
                        return presetConfig.width;
                    } else {
                        return imageRatio * presetConfig.height;
                    }
                },
                getHeight: function(imageWidth, imageHeight, presetConfig) {
                    return presetConfig.height;
                }
            }
        }

        self.getWidth = function(imageWidth, imageHeight, preset) {
            var config = self.presets[preset];
            return self.filters[config.filter].getWidth(imageWidth, imageHeight, config);
        }

        self.getHeight = function(imageWidth, imageHeight, preset) {
            var config = self.presets[preset];
            return self.filters[config.filter].getHeight(imageWidth, imageHeight, config);
        }
    }
    presetManager = new PresetManager();









});

define('ko_photoUpload', ['knockout', 'knockout.mapping', 'photo/Photo', 'photo/PhotoAttach', 'photo/PhotoAlbum', 'bootstrap', 'jquery_file_upload', 'jquery.ui', 'photo/thumb', 'photo/photoUploadBinding'], function(ko, mapping, Photo, PhotoAttach, PhotoAlbum) {


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
                return photo.id;
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
                ko.bindingHandlers.photoUpload.callback(photo);
            });
        } else {
            ko.bindingHandlers.photoUpload.callback(self.photo());
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
            if (response.form.success) {
                mapping.fromJS(response.photo, {}, photo);
                photo.status(PhotoUpload.prototype.STATUS_SUCCESS);
            } else {
                photo.error(response.form.error);
                photo.status(PhotoUpload.prototype.STATUS_FAIL);
            }
        }
    }
    PhotoUploadViewModel.prototype = Object.create(PhotoAddViewModel.prototype);
    PhotoUploadViewModel.prototype.add = function() {
        var self = this;
        $.post('/photo/upload/attach/', { collectionId : self.collectionId, ids : self.photoIds() }, function(response) {
            if (response.success) {
                PhotoAddViewModel.prototype.add.call(self);
            }
        }, 'json');
    }
    PhotoUploadViewModel.prototype.removePhotoInternal = function(photo) {
        var self = this;
        if (photo.status() == PhotoUpload.prototype.STATUS_LOADING) {
            photo.jqXHR.abort();
        }
        PhotoAddViewModel.prototype.removePhotoInternal.call(self, photo);
    };


    // Mixin, общие методы для двух форм загрузки с компьютера
    function asFromComputer() {
        this.populatePhoto = function(data) {
            var jqXHR = data.submit();
            return new PhotoUpload({ original_name : data.files[0].name }, jqXHR, this);
        }

        this.fileUploadSettings = {
            dataType: 'json',
            url: '/photo/upload/fromComputer/'
        };
    }

    // Модель одиночной загрузки файла с компьютера
    function FromComputerSingleViewModel(data) {
        var self = this;
        PhotoUploadViewModel.apply(self, arguments);

        $.extend(self.fileUploadSettings, {
            add: function (e, data) {
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

    // Модель множественной загрузки с компьютера
    function FromComputerMultipleViewModel(data) {
        var self = this;
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

        self.fileUploadSettingsMore = $.extend({}, self.fileUploadSettings);
        self.fileUploadSettingsMore.dropZone = null;
    }
    FromComputerMultipleViewModel.prototype = Object.create(PhotoUploadViewModel.prototype);
    asFromComputer.call(FromComputerMultipleViewModel.prototype);

    // Модель загрузки по URL
    function ByUrlViewModel() {
        var self = this;
        PhotoUploadViewModel.apply(self, arguments);

        self.url = ko.observable('');
        self.throttledUrl = ko.computed(self.url).extend({ throttle: 400 });

        self.throttledUrl.subscribe(function(val) {
            if (val.length > 0) {
                self.added(new PhotoUpload({}, self));

                self.photo().jqXHR = $.ajax({
                    url: '/photo/upload/byUrl/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        url : val
                    },
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
    function PhotoUpload(data, jqXHR, parent) {
        var self = this;
        Photo.apply(self, arguments);

        self.jqXHR = jqXHR;
        self.status = ko.observable(PhotoUpload.prototype.STATUS_LOADING);
        self.error = ko.observable();

        self.rotateLeft = function() {
            self.rotate(-90);
        };

        self.rotateRight = function() {
            self.rotate(90);
        };

        self.rotate = function(angle) {
            $.post('/photo/upload/rotate/', { angle : angle, photoId : self.id }, function(response) {
                mapping.fromJS(response.photo, {}, self);
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

        self.albums = ko.observableArray(ko.utils.arrayMap(data.albums, function(album) {
            return new PhotoAlbum(album);
        }));

        self.unselectAlbum = function() {
            self.currentAlbum(null);
        };

        self.selectAlbum = function(album) {
            if (album.photoCollection().attaches().length == 0) {
                $.get('/photo/collection/getAttaches/', { collectionId : album.photoCollection().id() }, function(response) {
                    album.photoCollection().attaches(ko.utils.arrayMap(response, function(attach) {
                        return new FromAlbumsPhotoAttach(attach, self);
                    }));
                    self.currentAlbum(album);
                }, 'json');
            } else {
                self.currentAlbum(album);
            }
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
        ByUrlViewModel: ByUrlViewModel
    };
});