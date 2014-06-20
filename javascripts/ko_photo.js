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
    self.photos = ko.observableArray();
    self.test = ko.observable(true);

    self.addPhoto = function(original_name) {
        self.photos.push(new PhotoUpload({ original_name : original_name }));
    }

    self.findPhotoByName = function(name) {
        return ko.utils.arrayFirst(self.photos(), function (photo) {
            return photo.original_name == name;
        });
    };

    self.fileUploadSettings = {
        dropZone: '.popup-add_frame__multi',
        url: '/photo/upload/fromComputer/',
        add: function (e, data) {
            console.log(data.files);

            self.addPhoto(data.files[0].name);
            data.submit();
        },
        done: function (e, data) {
            console.log(data.files);
            var photo = self.findPhotoByName(data.files[0].name);
            //console.log(photo);
            //$.extend(photo, new PhotoUpload(data));
            photo.status(photo.STATUS_SUCCESS);
        },
        fail: function(e, data) {
            var photo = self.findPhotoByName(data.files[0].name);
            photo.status(photo.STATUS_FAIL);
        }
    }
}

function PhotoUpload(data) {
    var self = this;
    $.extend(self, new Photo(data));

    self.STATUS_LOADING = 0;
    self.STATUS_SUCCESS = 1;
    self.STATUS_FAIL = 2;

    self.status = ko.observable(self.STATUS_LOADING);
    self.errors = ko.observableArray();

    self.cssClass = ko.computed(function() {
        switch (self.status()) {
            case self.STATUS_LOADING:
                return 'photo-pending';
            case self.STATUS_SUCCESS:
                return 'photo-success';
            case self.STATUS_FAIL:
                return 'photo-fail';
        }
    });
}

function Photo(data) {
    var self = this;
    self.original_name = data.original_name;
}