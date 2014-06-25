ko.bindingHandlers.photoUpload = {
    init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
        $(element).magnificPopup({
            type: 'ajax',
            ajax: {
                settings: {
                    url: '/photo/upload/form/',
                    data : valueAccessor()
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

    if (self.multiple) {
        PhotoUploadMultipleViewModel.apply(self);
    } else {
        PhotoUploadSingleViewModel.apply(self);
    }
}

function PhotoUploadSingleViewModel() {
    var self = this;
    self.photo = ko.observable(null);
}

function PhotoUploadMultipleViewModel() {
    var self = this;
    self.photos = ko.observableArray([]);
}

function FromComputerViewModel(data) {
    var self = this;
    PhotoUploadViewModel.apply(self, arguments);

    self.populatePhoto = function(data) {
        var jqXHR = data.submit();
        return new PhotoUploadFromComputer({ original_name : data.files[0].name }, jqXHR, self);
    }

    self.photoDone = function(photo, data) {
        photo.previewUrl = data.files[0].preview.toDataURL();
        photo.status(PhotoUpload.STATUS_SUCCESS);
    }

    self.fileUploadSettings = {
        url: '/photo/upload/fromComputer/',
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 155,
        previewMaxHeight: 110,
        previewCrop: true
    };
}

function FromComputerSingleViewModel(data) {
    var self = this;
    FromComputerViewModel.apply(self, arguments);

    self.removePhoto = function() {
        if (self.photo().status() == PhotoUpload.STATUS_LOADING) {
            self.photo().jqXHR.abort();
        } else {
            self.photo(null);
        }
    }

    $.extend(self.fileUploadSettings, {
        add: function (e, data) {
            self.photo(self.populatePhoto(data));
            $.blueimp.fileupload.prototype.options.add.call(this, e, data);
        },
        done: function (e, data) {
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

function FromComputerMultipleViewModel(data) {
    var self = this;
    FromComputerViewModel.apply(self, arguments);

    self.findPhotoByName = function(name) {
        return ko.utils.arrayFirst(self.photos(), function (photo) {
            return photo.original_name == name;
        });
    };

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
            self.photos.push(self.populatePhoto(data));
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

function ByUrlViewModel() {
    var self = this;
    PhotoUploadViewModel.apply(self, arguments);

    self.url = ko.observable('');

    self.url.subscribe(function(val) {
        $.post('/photo/upload/byUrl/', { url : val }, function(response) {
            console.log(response);
        }, 'json');
    });
}

function Photo(data) {
    var self = this;
    self.original_name = data.original_name;
}

function PhotoUpload(data, parent) {
    var self = this;
    Photo.apply(self, arguments);

    self.previewUrl = ko.observable();
    self.status = ko.observable(PhotoUpload.STATUS_LOADING);
    self.errors = ko.observableArray();

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