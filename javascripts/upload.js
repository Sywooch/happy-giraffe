/**
 * Загрузка фото
 * Author: alexk984
 * Date: 28.06.13
 */
function UploadPhotos(data) {
    var self = this;
    self.photos = ko.observableArray([]);
    if (data) {
        ko.utils.arrayForEach(data, function (photo) {
            self.photos.push(new UploadedPhoto(null, self, photo));
        });
    }
    self.active = false;

    self.onFiles = function (files) {
        FileAPI.each(files, function (file) {
            if (file.size >= 6 * FileAPI.MB) {
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
        var photo = new UploadedPhoto(file, self, null);
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

    self.getPhotoIds = function () {
        var ids = [];
        for (var i = 0; i < self.photos().length; i++)
            ids.push(self.photos()[i].id());

        return ids;
    };

    //Когда над блоком находится курсор c перетаскиваемой фотографией на блок .b-add-img нужно добавить класс .dragover
    var bl = $('.b-add-img__for-multi');
    if (bl.length > 0){
        bl[0].ondragover = function() {$('.b-add-img').addClass('dragover')};
        bl[0].ondragleave = function() {$('.b-add-img').removeClass('dragover')};
    }
    bl = $('.b-add-img__for-single');
    if (bl.length > 0){
        bl[0].ondragover = function() {$('.b-add-img').addClass('dragover')};
        bl[0].ondragleave = function() {$('.b-add-img').removeClass('dragover')};
    }
}

function UploadedPhoto(file, parent, photo) {
    var self = this;

    self.parent = parent;
    self.canvas = ko.observable('');
    self.html = '';

    if (file != null) {
        self.file = file;
        self.uid = FileAPI.uid(file);
        self.id = ko.observable('');
        self.status = ko.observable(0);
        self._progress = ko.observable(0);

        if (/^image/.test(self.file.type)) {
            if (self.parent.photos().length == 0)
                FileAPI.Image(self.file).preview(480, 250).rotate('auto').get(function (err, img) {
                    $('#uploaded_photo_' + self.uid + ' .js-image').prepend(img);
                });
            else{
                if (self.parent.photos().length == 1){

                    //переделываем превью первой фотки на маленькое
                    var first_image = self.parent.photos()[0];
                    if (first_image.file){
                        FileAPI.Image(first_image.file).preview(195, 125).rotate('auto').get(function (err, img) {
                            first_image.canvas(img);
                            $('#uploaded_photo_' + first_image.uid + ' .js-image').html('').prepend(img);
                        });
                    }
                }
                FileAPI.Image(self.file).preview(195, 125).rotate('auto').get(function (err, img) {
                    self.canvas(img);
                    $('#uploaded_photo_' + self.uid + ' .js-image').prepend(img);
                });
            }
        }
    } else {
        self.file = null;
        self.id = ko.observable(photo.id);
        self.uid = photo.id;
        self.status = ko.observable(2);
        self._progress = ko.observable(100);
        self.url = photo.url;
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
                var percent = evt.loaded / evt.total * 100;
                self._progress(percent);
            },
            complete: function (err, xhr) {
                var response = $.parseJSON('[' + xhr.response + ']')[0];
                self.id(response.id);
                self.html = response.html;
                self._progress(100);
                self.status(2);
                $('#uploaded_photo_' + self.uid + ' .js-image').css({ opacity: 1 });
                self.parent.active = false;
                self.parent.start();
            }
        });
    };

    self.progress = ko.computed(function () {
        return self._progress() + '%';
    });

    self.remove = function () {
        if (self.file && self.file.xhr)
            self.file.xhr.abort();
        self.parent.photos.remove(self);
    };
    self.isSingle = ko.computed(function () {
        return self.parent.photos().length == 1;
    });
}