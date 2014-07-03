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
            })
            dropZone.on('dragleave', function() {
                dropZone.removeClass('dragover');
            })
        }
    }
};

ko.bindingHandlers.thumb = {
    init: function (element, valueAccessor) {
        var value = valueAccessor();
        var photo = value.photo;
        var preset = value.preset;

        var src = 'http://img.virtual-giraffe.ru/proxy_public_file/v2/thumbs/' + preset + '/' + photo.fs_name();
        $(element).attr('src', src);

        photo.fs_name.subscribe(function(fs_name) {
            var src = 'http://img.virtual-giraffe.ru/proxy_public_file/v2/thumbs/' + preset + '/' + photo.fs_name();
            $(element).attr('src', src);
        });
    }
};

// Основная модель загрузки фото
function PhotoUploadViewModel(data) {
    var self = this;

    self.multiple = data.multiple;
    self.photos = ko.observableArray([]);
    self.photo = ko.computed({
        read: function () {
            return self.photos().length > 0 ? self.photos()[0] : null;
        },
        write: function (value) {
            self.photos([value]);
        }
    });

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

    self.added = function(photo) {
        if (self.multiple) {
            self.photos.push(photo);
        } else {
            self.photo(photo);
        }
    }

    self.removePhoto = function(photo) {
        if (photo.status() == PhotoUpload.STATUS_LOADING) {
            photo.jqXHR.abort();
            self.photos.remove(photo);
        } else {
            self.photos.remove(photo);
        }
    }

    self.processResponse = function(photo, response) {
        if (response.form.success) {
            ko.mapping.fromJS(response.photo, {}, photo);
            photo.status(PhotoUpload.STATUS_SUCCESS);
        } else {
            photo.error(response.form.firstError);
            photo.status(PhotoUpload.STATUS_FAIL);
        }
    }

    self.photoIds = function() {
        return ko.utils.arrayMap(self.photos(), function(photo) {
            return photo.id;
        });
    }

    self.add = function() {
        $.post('/photo/upload/attach/', { collectionId : 1, ids : self.photoIds() }, function(response) {
            if (response.success) {
                if (data.multiple) {
                    ko.utils.arrayForEach(self.photos(), function(photo) {
                        ko.bindingHandlers.photoUpload.callback(photo);
                    });
                } else {
                    ko.bindingHandlers.photoUpload.callback(self.photo());
                }
            }
        }, 'json');
    }
}

// Mixin, общие методы для двух форм загрузки с компьютера
function asFromComputer() {
    this.populatePhoto = function(data) {
        var jqXHR = data.submit();
        return new PhotoUpload({ original_name : data.files[0].name }, jqXHR, this);
    }

    this.photoDone = function(photo, data) {
//        if (data.files[0].preview) {
//            photo.previewUrl = data.files[0].preview.toDataURL();
//        }
        this.processResponse(photo, data.result);
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
        maxNumberOfFiles: 1,
        add: function (e, data) {
            self.added(self.populatePhoto(data));
            $.blueimp.fileupload.prototype.options.add.call(this, e, data);
        },
        done: function (e, data) {
            self.photo().file = data.files[0];
            self.photoDone(self.photo(), data);
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

    self.findPhotoByName = function(name) {
        return ko.utils.arrayFirst(self.photos(), function (photo) {
            return photo.original_name == name;
        });
    };

    self.cancelAll = function()
    {
        ko.utils.arrayForEach(self.loadingPhotos(), function(photo) {
            photo.jqXHR.abort();
        });
    }

    $.extend(self.fileUploadSettings, {
        dropZone: '.popup-add_frame__multi',
        add: function (e, data) {
            self.added(self.populatePhoto(data));
            $.blueimp.fileupload.prototype.options.add.call(this, e, data);
        },
        done: function (e, data) {
            var photo = self.findPhotoByName(data.files[0].name);
            self.photoDone(photo, data);
        },
        fail: function(e, data) {
            var photo = self.findPhotoByName(data.files[0].name);
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
        self.added(new PhotoUpload({}, self));

        self.photo().jqXHR = $.ajax({
            url: '/photo/upload/byUrl/',
            type: 'POST',
            dataType: 'json',
            data: {
                url : self.url()
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
    });
}

function PhotoAlbum(data) {
    var self = this;
    self.id = data.id;
    self.title = data.title;
    self.cover = new Photo(data.cover);
    self.count = data.count;
    self.photos = ko.utils.arrayMap(data, function(data) {
        return new Photo(data);
    });
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

// Модель фотографии в рамках функционала загрузки фото
function PhotoUpload(data, jqXHR, parent) {
    var self = this;
    Photo.apply(self, arguments);

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
            ko.mapping.fromJS(response.photo, {}, self);
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

function FromAlbumsViewModel(data) {
    var self = this;
    self.albums = ko.utils.arrayMap(data, function(data) {
        return new PhotoAlbum(data);
    });

    self.currentAlbum = ko.observable(null);

    self.selectAlbum = function(album) {
        self.currentAlbum(album);
    }
}

