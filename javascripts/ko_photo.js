ko.bindingHandlers.photoUpload = {
    init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
        $(element).magnificPopup({
            type: 'ajax',
            ajax: {
                settings: {
                    url: '/photo/upload/form/'
                }
            }
        });
    }
};

ko.bindingHandlers.fileUpload = {
    update: function (element, valueAccessor) {
        var options = valueAccessor() || {};
        $(element).fileupload(options).on('fileuploadprocessalways', function (e, data) {
//            alert('123');
        });

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

ko.bindingHandlers.canvas = {
    init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {

    },
    update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
        var context = valueAccessor().getContext('2d');
        context.drawImage(element, 0, 0);
    }
};

function PhotoUploadViewModel() {
    var self = this;

    self.STATUS_LOADING = 0;
    self.STATUS_SUCCESS = 1;
    self.STATUS_FAIL = 2;

    self.photos = ko.observableArray([]);

    self.addPhoto = function(original_name, jqXHR, previewUrl) {
        self.photos.push(new PhotoUpload({ original_name : original_name }, jqXHR, previewUrl, self));
    };

    self.findPhotoByName = function(name) {
        return ko.utils.arrayFirst(self.photos(), function (photo) {
            return photo.original_name == name;
        });
    };

    self.loadingPhotos = ko.computed(function() {
        return ko.utils.arrayFilter(self.photos(), function(photo) {
            return photo.status() == self.STATUS_LOADING;
        });
    });

    self.successPhotos = ko.computed(function() {
        return ko.utils.arrayFilter(self.photos(), function(photo) {
            return photo.status() == self.STATUS_SUCCESS;
        });
    });

    self.loading = ko.computed(function() {
        return self.loadingPhotos().length > 0;
    });

    self.removePhoto = function(photo) {
        if (photo.status() == self.STATUS_LOADING) {
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


    var originalAdd = $.blueimp.fileupload.prototype.options.add;
    self.fileUploadSettings = {
        dropZone: '.popup-add_frame__multi',
        url: '/photo/upload/fromComputer/',
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 155,
        previewMaxHeight: 110,
        previewCrop: true,
        add: function (e, data) {
            var jqXHR = data.submit();
            self.addPhoto(data.files[0].name, jqXHR, URL.createObjectURL(data.files[0]));
            originalAdd.call(this, e, data);
        },
        done: function (e, data) {
            var photo = self.findPhotoByName(data.files[0].name);

            photo.preview = data.files[0].preview.toDataURL();

            console.log(data.files[0].preview.getContext('2d'));

            //console.log(photo);
            //$.extend(photo, new PhotoUpload(data));
            photo.status(self.STATUS_SUCCESS);
        },
        fail: function(e, data) {
            var photo = self.findPhotoByName(data.files[0].name);
            if (data.errorThrown == 'abort') {
                self.photos.remove(photo);
            } else {
                photo.status(self.STATUS_FAIL);
            }
        }
    };
}

function PhotoUpload(data, jqXHR, previewUrl, parent) {
    var self = this;
    ko.utils.extend(self, new Photo(data));

    self.previewUrl = previewUrl;
    self.jqXHR = jqXHR;
    self.status = ko.observable(parent.STATUS_LOADING);
    self.errors = ko.observableArray();

    self.cssClass = ko.computed(function() {
        switch (self.status()) {
            case parent.STATUS_LOADING:
                return 'i-photo__load';
            case parent.STATUS_SUCCESS:
                return 'i-photo__loaded';
            case parent.STATUS_FAIL:
                return 'i-photo__error';
        }
    });
}

function Photo(data) {
    var self = this;
    self.original_name = data.original_name;
}