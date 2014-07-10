define('ko_photo', ['knockout'], function(ko) {
    // Основная модель коллекции
    function PhotoCollection(data) {
        var self = this;
        self.id = ko.observable(data.id);
        self.attachesCount = ko.observable(data.attachesCount);
        self.attaches = ko.observableArray(ko.utils.arrayMap(data.attaches, function(attach) {
            return new PhotoAttach(attach);
        }));
        self.cover = ko.observable(data.cover === null ? null : new Photo(data.cover));
    }

    // Основная модель аттача
    function PhotoAttach(data) {
        var self = this;
        self.id = ko.observable(data.id);
        self.position = ko.observable(data.position);
        self.photo = ko.observable(new Photo(data.photo));
    }

    // Основная модель фотоальбома
    function PhotoAlbum(data) {
        var self = this;
        self.id = ko.observable(data.id);
        self.title = ko.observable(data.title);
        self.description = ko.observable(data.description);
        self.photoCollection = ko.observable(new PhotoCollection(data.photoCollection));
    }

    // Основная модель фотографии
    function Photo(data) {
        var self = this;
        self.id = ko.observable(data.id);
        self.title = ko.observable(data.title);
        self.original_name = ko.observable(data.original_name);
        self.width = ko.observable(data.width);
        self.height = ko.observable(data.height);
        self.fs_name = ko.observable(data.fs_name);
        self.originalUrl = ko.observable(data.originalUrl);
    }

    return {
        Photo: Photo,
        PhotoAttach: PhotoAttach,
        PhotoAlbum: PhotoAlbum,
        PhotoCollection: PhotoCollection
    }
});

define('ko_photoUpload', ['knockout', 'knockout.mapping', 'ko_photo', 'bootstrap', 'jquery_file_upload', 'jquery.ui'], function(ko, mapping, ko_photo) {
    // Биндинг для загрузки фото
    ko.bindingHandlers.photoUpload = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            var value = valueAccessor();
            var data = value.data;
            var observable = value.observable;

            var defaultCallback = function(photo) {
                if (observable() instanceof Array) {
                    observable.push(photo);
                } else {
                    observable(photo);
                }
            }

            var callback = value.callback || defaultCallback;

            ko.bindingHandlers.photoUpload.callback = function(photo) {
                callback(photo);
                $.magnificPopup.close();
            };

            $(element).magnificPopup({
                type: 'ajax',
                ajax: {
                    settings: {
                        url: '/photo/upload/form/',
                        data : data
                    }
                }
            });
        }
    };

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

    // Биндинг для отображения миниатюр
    ko.bindingHandlers.thumb = {
        update: function (element, valueAccessor) {
            var value = valueAccessor();
            var photo = value.photo;
            var preset = value.preset;

            function update() {
                var src = 'http://img.virtual-giraffe.ru/proxy_public_file/thumbs/' + preset + '/' + photo.fs_name();
                src = 'http://img2.dev.happy-giraffe.ru/thumbs/' + preset + '/' + photo.fs_name();
                //src = 'https://test-happygiraffe.s3.amazonaws.com/thumbs/' + preset + '/' + photo.fs_name();
                $(element).attr('src', src);
            }

            update();

            photo.fs_name.subscribe(function(fs_name) {
                update();
            });
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
                    self.removePhoto(self.photo());
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
    }
    PhotoAddViewModel.prototype.removePhoto = function(photo) {
        var self = this;
        self.photos.remove(photo);
    }

    // Основная модель загрузки фото
    function PhotoUploadViewModel(data) {
        var self = this;
        PhotoAddViewModel.apply(self, arguments);

        self.loadingPhotos = ko.computed(function() {
            return ko.utils.arrayFilter(self.photos(), function(photo) {
                return photo.status() == PhotoUpload.STATUS_LOADING;
            });
        });

        self.successPhotos = ko.computed(function() {
            return ko.utils.arrayFilter(self.photos(), function(photo) {
                return photo.status() == PhotoUpload.STATUS_SUCCESS;
            });
        });

        self.loading = ko.computed(function() {
            return self.loadingPhotos().length > 0;
        });

        self.removePhoto = function(photo) {
            if (photo.status() == PhotoUpload.STATUS_LOADING) {
                photo.jqXHR.abort();
            }
            PhotoAddViewModel.prototype.removePhoto.call(self, photo);
        }

        self.processResponse = function(photo, response) {
            if (response.form.success) {
                mapping.fromJS(response.photo, {}, photo);
                photo.status(PhotoUpload.STATUS_SUCCESS);
            } else {
                photo.error(response.form.firstError);
                photo.status(PhotoUpload.STATUS_FAIL);
            }
        }

        self.add = function() {
            $.post('/photo/upload/attach/', { collectionId : self.collectionId, ids : self.photoIds() }, function(response) {
                if (response.success) {
                    PhotoAddViewModel.prototype.add.call(self);
                }
            }, 'json');
        }
    }
    PhotoUploadViewModel.prototype = Object.create(PhotoAddViewModel.prototype);

    // Mixin, общие методы для двух форм загрузки с компьютера
    function asFromComputer() {
        this.populatePhoto = function(data) {
            var jqXHR = data.submit();
            return new PhotoUpload({ original_name : data.files[0].name }, jqXHR, this);
        }

        this.fileUploadSettings = {
            dataType: 'json',
            url: '/photo/upload/fromComputer/',
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 155,
            previewMaxHeight: 110
        };
    }

    // Модель одиночной загрузки файла с компьютера
    function FromComputerSingleViewModel(data) {
        var self = this;
        PhotoUploadViewModel.apply(self, arguments);

        $.extend(self.fileUploadSettings, {
            add: function (e, data) {
                self.added(self.populatePhoto(data));
                $.blueimp.fileupload.prototype.options.add.call(this, e, data);
            },
            done: function (e, data) {
                self.photo().file = data.files[0];
                self.processResponse(self.photo(), data.result);
            },
            fail: function(e, data) {
                if (data.errorThrown != 'abort') {
                    self.photo().status(PhotoUpload.STATUS_FAIL);
                }
            }
        });
    }
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
                self.removePhoto(photo);
            });
        }

        $.extend(self.fileUploadSettings, {
            dropZone: '.popup-add_frame__multi',
            add: function (e, data) {
                if (self.successPhotos().length < 300) {
                    self.added(self.populatePhoto(data));
                    $.blueimp.fileupload.prototype.options.add.call(this, e, data);
                }
            },
            done: function (e, data) {
                var photo = self.findPhotoByRequest(data.jqXHR);
                self.processResponse(photo, data.result);
            },
            fail: function(e, data) {
                var photo = self.findPhotoByRequest(data.jqXHR);
                if (data.errorThrown != 'abort') {
                    photo.status(PhotoUpload.STATUS_FAIL);
                }
            }
        });

        self.fileUploadSettingsMore = $.extend({}, self.fileUploadSettings);
        self.fileUploadSettingsMore.dropZone = null;
    }
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
                            self.photo().status(PhotoUpload.STATUS_FAIL);
                        }
                    }
                });
            } else {
                self.photo(null);
            }
        });
    }

    // Модель фотографии в рамках функционала загрузки фото
    function PhotoUpload(data, jqXHR, parent) {
        var self = this;
        ko_photo.Photo.apply(self, arguments);

        self.jqXHR = jqXHR;
        self.previewUrl = ko.observable();
        self.status = ko.observable(PhotoUpload.STATUS_LOADING);
        self.error = ko.observable();

        self.rotateLeft = function() {
            self.rotate(-90);
        }

        self.rotateRight = function() {
            self.rotate(90)
        }

        self.rotate = function(angle) {
            $.post('/photo/upload/rotate/', { angle : angle, photoId : self.id }, function(response) {
                mapping.fromJS(response.photo, {}, self);
            }, 'json');
        }

        self.cssClass = ko.computed(function() {
            switch (self.status()) {
                case PhotoUpload.STATUS_LOADING:
                    return 'i-photo__load';
                case PhotoUpload.STATUS_SUCCESS:
                    return 'i-photo__loaded';
                case PhotoUpload.STATUS_FAIL:
                    return 'i-photo__error';
            }
        });
    }
    PhotoUpload.STATUS_LOADING = 0;
    PhotoUpload.STATUS_SUCCESS = 1;
    PhotoUpload.STATUS_FAIL = 2;

    function FromAlbumsPhotoAttach(data, parent) {
        var self = this;
        ko_photo.PhotoAttach.apply(self, arguments);

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
            return new ko_photo.PhotoAlbum(album);
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

    window.PhotoUpload = PhotoUpload;

    return {
        FromComputerSingleViewModel: FromComputerSingleViewModel,
        FromComputerMultipleViewModel: FromComputerMultipleViewModel,
        FromAlbumsViewModel: FromAlbumsViewModel,
        ByUrlViewModel: ByUrlViewModel
    };
});