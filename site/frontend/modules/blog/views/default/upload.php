<?php
Yii::app()->clientScript
    ->registerScript('file-upload2', 'var FileAPI = { debug: false, pingUrl: false }', CClientScript::POS_HEAD)
    ->registerScriptFile('/javascripts/upload/FileAPI.min.js', CClientScript::POS_BEGIN)
    ->registerScriptFile('/javascripts/upload/FileAPI.id3.js', CClientScript::POS_BEGIN)
    ->registerScriptFile('/javascripts/upload/FileAPI.exif.js', CClientScript::POS_BEGIN);

?>


<div id="preview">
    <!-- ko foreach: photos -->
    <div>
        <div class="uploaded-image" data-bind="attr: {id: 'img_preview' + uid}">
        </div>

        <a href="" data-bind="click: remove">delete</a>
        <span data-bind="text: progress"></span>
        <!-- ko if: status() == 2 -->
        <span>uploaded</span>
        <!-- /ko -->
    </div>
    <!-- /ko -->
</div>

<div id="oooops" style="display: none; margin: 10px; padding: 10px; border: 2px solid #f60; border-radius: 4px;">
    Увы, ваш браузер не поддерживает html5 и flash,
    поэтому смотреть тут нечего, а iframe не даёт всей красоты :]
</div>

<div id="drop-zone" class="b-dropzone" style="display: none;width: 200px;height: 200px;">
    <div class="b-dropzone__bg"></div>
    <div class="b-dropzone__txt">Drop files there</div>
</div>

<div class="b-button js-fileapi-wrapper">
    <div class="b-button__text">Multiple</div>
    <input id="upload-files-multiple" name="files" class="b-button__input" type="file" multiple/>
</div>

<script type="text/javascript">

    function UploadPhotos() {
        var self = this;
        self.photos = ko.observableArray([]);
        self.active = false;

        self.add = function (file) {
            var photo = new UploadedPhoto(file, self);
            self.photos.push(photo);
        };
        self.start = function () {
            if (!self.active)
                ko.utils.arrayFirst(this.photos(), function (photo) {
                    if (photo.status() == 0) {
                        photo.upload();
                        return true;
                    }
                    return false;
                });
        };
        self._getEl = function (file) {
            ko.utils.arrayForEach(this.photos(), function (photo) {
                if (photo.uid == FileAPI.uid(file))
                    return photo;
            });
        };
    }

    function UploadedPhoto(file, parent) {
        var self = this;

        self.parent = parent;
        self.file = file;
        self.image = ko.observable();
        self.uid = FileAPI.uid(file);
        self.id = ko.observable('');
        self.status = ko.observable(0);
        self.progress = ko.observable(0);

        if (/^image/.test(self.file.type)) {
            FileAPI.Image(self.file).preview(150).rotate('auto').get(function (err, img) {
                $('#img_preview' + self.uid).append(img);
                if (!err)
                    self.image(img.outerHTML);
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
    uploadPhotos = new UploadPhotos();
    ko.applyBindings(uploadPhotos, document.getElementById('preview'));



    $(function () {
        if (!(FileAPI.support.cors || FileAPI.support.flash)) {
            $('#oooops').show();
            $('#buttons-panel').hide();
        }

        if (FileAPI.support.dnd) {
            $('#drop-zone').show();
            $(document).dnd(function (over) {
            }, function (files) {
                onFiles(files);
            });
        }

        $('#upload-files-multiple').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });


        function onFiles(files) {
            FileAPI.each(files, function (file) {
                if (file.size >= 25 * FileAPI.MB) {
                    alert('Sorrow.\nMax size 25MB')
                }
                else if (file.size === void 0) {
                    $('#oooops').show();
                    $('#buttons-panel').hide();
                }
                else {
                    uploadPhotos.add(file);
                }
            });

            uploadPhotos.start();
        }

    });
</script>