/**
 * Загрузка фото
 * Author: alexk984
 * Date: 28.06.13
 */
function UploadPhotos() {
    var self = this;
    self.photos = ko.observableArray([]);
    self.active = false;

    self.onFiles = function(files) {
        FileAPI.each(files, function (file) {
            if (file.size >= 25 * FileAPI.MB) {
                alert('Sorrow.\nMax size 25MB')
            }
            else if (file.size === void 0) {
                $('#oooops').show();
                $('#buttons-panel').hide();
            }
            else {
                self.add(file);
            }
        });

        self.start();
    };
    self.add = function (file) {
        var photo = new UploadedPhoto(file, self);
        self.photos.push(photo);
    };
    self.start = function () {
        if (!self.active)
            ko.utils.arrayFirst(self.photos(), function (photo) {
                if (photo.status() == 0) {
                    photo.upload();
                    return true;
                }
                return false;
            });
    };
}

function UploadedPhoto(file, parent) {
    var self = this;

    self.parent = parent;
    self.file = file;
    self.uid = FileAPI.uid(file);
    self.id = ko.observable('');
    self.status = ko.observable(0);
    self.progress = ko.observable(0);

    if (/^image/.test(self.file.type)) {
        FileAPI.Image(self.file).preview(195, 125).rotate('auto').get(function (err, img) {
            $('#uploaded_photo_' + self.uid).prepend(img);
        });
    }

    self.upload = function () {
        self.file.xhr = FileAPI.upload({
            url: '/ajaxSimple/uploadPhoto/',
            imageAutoOrientation: true,
            files: { file: file },
            upload: function () {
                self.status(1);
            },
            progress: function (evt) {
                self.progress(evt.loaded / evt.total * 100);
            },
            complete: function (err, xhr) {
                self.progress(100);
                self.status(2);
                self.parent.active = false;
                self.parent.start();
            }
        });
    };

    self.remove = function () {
        if (self.file.xhr)
            self.file.xhr.abort();
        self.parent.photos.remove(self);
    };
}