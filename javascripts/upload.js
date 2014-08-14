/**
 * Загрузка фото
 * Author: alexk984
 * Date: 28.06.13
 */

(function(window) {
    function f(ko) {
        function UploadPhotos(data, multi, container_selector) {
            var self = this;
            self.photos = ko.observableArray([]);
            self.multi = ko.observable(multi);

            if (data) {
                ko.utils.arrayForEach(data, function (photo) {
                    self.photos.push(new UploadedPhoto(null, self, photo, ''));
                });
            }

            self.addPhoto = function (name) {
                if (self.multi() || self.photos().length < 1)
                    self.photos.push(new UploadedPhoto(name, self, null, ''));
            };
            self.getPhotoIds = function () {
                var ids = [];
                for (var i = 0; i < self.photos().length; i++)
                    ids.push(self.photos()[i].id());

                return ids;
            };
            self.findPhotoByName = function(name){
                var result = null;
                ko.utils.arrayForEach(self.photos(), function (photo) {
                    if (photo.name == name)
                        result = photo;
                });
                return result;
            };
            self.openLoad = function(data, event){
                if (self.photos().length < 1)
                    return true;
            };

            self.multiClass = ko.computed(function () {
                return self.multi() ? 'b-add-img__for-multi' : 'b-add-img__for-single';
            });
            self.loadActive = ko.computed(function () {
                if (!self.multi())
                    return self.photos().length == 0;
                return true;
            });
            self.addActive = ko.computed(function () {
                return self.photos().length > 0;
            });

            //Когда над блоком находится курсор c перетаскиваемой фотографией на блок .b-add-img нужно добавить класс .dragover
            $.each($('.b-add-img'), function () {
                $(this)[0].ondragover = function () {
                    $('.b-add-img').addClass('dragover')
                };
                $(this)[0].ondragleave = function () {
                    $('.b-add-img').removeClass('dragover')
                };
            });

            $(container_selector+' .js-upload-files-multiple').fileupload({
                dataType: 'json',
                url: '/ajaxSimple/uploadPhoto/',
                dropZone: $(container_selector).find('.drop-files'),
                add: function (e, data) {
                    if (self.multi() || self.photos().length < 1){
                        self.addPhoto(data.files[0].name);
                        data.submit();
                    }
                },
                done: function (e, data) {
                    self.findPhotoByName(data.files[0].name).complete(data.result);
                }
            });

            $(container_selector+' .js-upload-files-multiple').bind('fileuploadprogress', function (e, data) {
                self.findPhotoByName(data.files[0].name)._progress(data.loaded * 100 / data.total);
            });

            self.photos.subscribe(function() {
                if ($('.redactor_btn_image').length > 0)
                    setPopupPosition($('.redactor_btn_image'), $('.redactor-popup_b-photo'));
            });
        }

        function UploadedPhoto(name, parent, photo, error) {
            var self = this;

            self.parent = parent;
            self.name = name;
            self.error = ko.observable(error);
            self.html = '';

            if (name != null) {
                self.id = ko.observable('');
                self.status = ko.observable(0);
                self._progress = ko.observable(0);
                self.url = ko.observable('');
            } else {
                self.id = ko.observable(photo.id);
                self.status = ko.observable(2);
                self._progress = ko.observable(100);
                self.url = ko.observable(photo.url);
            }

            self.complete = function (response) {
                self.id(response.id);
                self.html = response.html;
                self.comment_html = response.comment_html;
                self.status(2);
                self.url(response.url);
            };

            self.progress = ko.computed(function () {
                return self._progress() + '%';
            });

            self.remove = function () {
                self.parent.photos.remove(self);
            };
            self.isSingle = ko.computed(function () {
                return self.parent.photos().length == 1;
            });
            self.isError = ko.computed(function () {
                return self.error() != '';
            });
        }

        return UploadPhotos;
    }

    if (typeof define === 'function' && define['amd']) {
        define('upload', ['knockout'], f);
    } else {
        window.UploadPhotos = f();
    }
})(window);