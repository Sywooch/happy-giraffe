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

ko.bindingHandlers.fileUpload = {
    update: function (element, valueAccessor) {
        var data = valueAccessor();
        var options = data.options || {};
        var multiple = data.multiple;
        var el = $(element);

        el.prop('multiple', multiple);

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

    self.processResponse = function(photo, response) {
        if (response.success) {
            $.extend(photo, response.attributes);
            photo.status(PhotoUpload.STATUS_SUCCESS);
        } else {
            photo.status(PhotoUpload.STATUS_FAIL);
        }
    }

    self.add = function() {
        if (data.multiple) {
            ko.utils.arrayForEach(self.photos(), function(photo) {
                ko.bindingHandlers.photoUpload.callback(photo);
            });
        } else {
            ko.bindingHandlers.photoUpload.callback(self.photo());
        }
    }
}

function asFromComputer() {
    this.populatePhoto = function(data) {
        var jqXHR = data.submit();
        return new PhotoUploadFromComputer({ original_name : data.files[0].name }, jqXHR, this);
    }

    this.photoDone = function(photo, data) {
        photo.previewUrl = data.files[0].preview.toDataURL();
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

function FromComputerSingleViewModel(data) {
    var self = this;
    PhotoUploadViewModel.apply(self, arguments);

    self.removePhoto = function() {
        if (self.photo().status() == PhotoUpload.STATUS_LOADING) {
            self.photo().jqXHR.abort();
        } else {
            self.photo(null);
        }
    }

    $.extend(self.fileUploadSettings, {
        add: function (e, data) {
            self.added(self.populatePhoto(data));
            $.blueimp.fileupload.prototype.options.add.call(this, e, data);
        },
        done: function (e, data) {
            self.photo().file = data.files[0];
            self.photoDone(self.photo(), data);
        },
        fail: function(e, data) {
            if (data.errorThrown == 'abort') {
                self.photo(null);
            } else {
                self.photo().status(PhotoUpload.STATUS_FAIL);
            }
        }
    });
}
asFromComputer.call(FromComputerSingleViewModel.prototype);

function FromComputerMultipleViewModel(data) {
    var self = this;
    PhotoUploadViewModel.apply(self, arguments);

    self.findPhotoByName = function(name) {
        return ko.utils.arrayFirst(self.photos(), function (photo) {
            return photo.original_name == name;
        });
    };

    self.removePhoto = function(photo) {
        if (photo.status() == PhotoUpload.STATUS_LOADING) {
            photo.jqXHR.abort();
        } else {
            self.photos.remove(photo);
        }
    }

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
            if (data.errorThrown == 'abort') {
                self.photos.remove(photo);
            } else {
                photo.status(PhotoUpload.STATUS_FAIL);
            }
        }
    });
}
asFromComputer.call(FromComputerMultipleViewModel.prototype);

function ByUrlViewModel() {
    var self = this;
    PhotoUploadViewModel.apply(self, arguments);

    self.url = ko.observable('');
    self.throttledUrl = ko.computed(self.url).extend({ throttle: 400 });

    self.throttledUrl.subscribe(function(val) {
        self.added(new PhotoUpload({}, self));
        $.post('/photo/upload/byUrl/', { url : val }, function(response) {
            self.processResponse(self.photo(), response);
        }, 'json');
    });
}

function Photo(data) {
    var self = this;
    self.id = data.id;
    self.title = data.title;
    self.original_name = data.original_name;
    self.imageUrl = data.imageUrl;
    self.width = data.width;
    self.height = data.height;
}

function PhotoUpload(data, parent) {
    var self = this;
    Photo.apply(self, arguments);

    self.previewUrl = ko.observable();
    self.status = ko.observable(PhotoUpload.STATUS_LOADING);
    self.errors = ko.observableArray();

    self.rotate = function() {
        console.log(self.file);
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

function PhotoUploadFromComputer(data, jqXHR, parent) {
    var self = this;
    PhotoUpload.apply(self, arguments);
    self.jqXHR = jqXHR;
}