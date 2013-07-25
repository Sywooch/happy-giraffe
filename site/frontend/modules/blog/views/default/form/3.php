<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
?>
<?php $this->renderPartial('form/script'); ?>

<div class="b-settings-blue b-settings-blue__photo"<?php if (!$model->isNewRecord) echo ' style="display:none;"' ?>>
    <div class="b-settings-blue_tale"></div>
    <div class="clearfix">

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Личные <br> фотоальбомы</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img1.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46" onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo').show();">Загрузить фото</a>
            </div>
        </div>

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Фотопост <br> в блоге</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img2.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46" onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo-post').show();">Создать фотопост</a>
            </div>
        </div>

    </div>
</div>

<?php $this->renderPartial('form/3_post', array('model' => $model, 'slaveModel'=>$slaveModel)); ?>

<?php $this->renderPartial('form/3_album'); ?>

<script type="text/javascript">
    $(function () {
        var PhotoPostViewModel = function (data) {
            var self = this;
            ko.utils.extend(self, new BlogFormViewModel(data));
            self.upload = ko.observable(new UploadPhotos(data.photos));

            self.add = function () {
                console.log(self.upload().getPhotoIds());
                $('#CommunityPhotoPost_photos').val(self.upload().getPhotoIds());

                if (self.upload().photos().length > 0)
                    $('#blog-form').submit()
            }
        };
        var formVM1 = new PhotoPostViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(formVM1, document.getElementById('popup-user-add-photo-post'));

        var PhotoAlbumViewModel = function () {
            var self = this;
            self.id = 0;
            self.upload = ko.observable(new UploadPhotos());

            self.add = function () {
                if (self.upload().photos().length > 0){
                    var photo_ids = [];
                    var a = self.upload().photos();
                    for (var i = 0; i < a.length; i++){
                        photo_ids.push(a[i].id());
                    }

                    $.post('/ajaxSimple/addPhoto/', {album_id: self.id, photo_ids: photo_ids}, function (response) {
                        if (response.status)
                            $.fancybox.close();
                    }, 'json');
                }
            }
        };
        var formVM2 = new PhotoAlbumViewModel();
        ko.applyBindings(formVM2, document.getElementById('popup-user-add-photo'));


        if (!(FileAPI.support.cors || FileAPI.support.flash)) {
            $('#oooops').show();
            $('#buttons-panel').hide();
        }

        if (FileAPI.support.dnd) {
            $('.b-add-img_html5-tx').show();

            $(document).dnd(function (over) {
            }, function (files) {
                formVM1.upload().onFiles(files);
                formVM2.upload().onFiles(files);
            });
        }

        $('#popup-user-add-photo .js-upload-files-multiple').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            formVM2.upload().onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });
        $('#popup-user-add-photo-post .js-upload-files-multiple').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            formVM1.upload().onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });
    });
</script>