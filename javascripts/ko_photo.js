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

function PhotoUploadViewModel() {
    var self = this;

    self.STATUS_LOADING = 0;
    self.STATUS_SUCCESS = 1;
    self.STATUS_FAIL = 2;

    self.photos = ko.observableArray([]);

    self.addPhoto = function(original_name, jqXHR) {
        self.photos.push(new PhotoUpload({ original_name : original_name }, jqXHR, self));
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
        }
        self.photos.remove(photo);
    }

    self.cancellAll = function()
    {
        ko.utils.arrayForEach(self.loadingPhotos(), function(photo) {
            photo.jqXHR.abort();
        });
    }

    self.fileUploadSettings = {
        dropZone: '.popup-add_frame__multi',
        url: '/photo/upload/fromComputer/',
        add: function (e, data) {
            var jqXHR = data.submit();
            self.addPhoto(data.files[0].name, jqXHR);
        },
        done: function (e, data) {
            var photo = self.findPhotoByName(data.files[0].name);
            //console.log(photo);
            //$.extend(photo, new PhotoUpload(data));
            photo.status(self.STATUS_SUCCESS);
        },
        fail: function(e, data) {
            if (e.errorThrown != 'abort') {
                var photo = self.findPhotoByName(data.files[0].name);
                photo.status(self.STATUS_FAIL);
            }
        }
    };
}

function PhotoUpload(data, jqXHR, parent) {
    var self = this;
    ko.utils.extend(self, new Photo(data));

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