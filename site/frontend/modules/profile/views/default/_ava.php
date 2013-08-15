<?php
/**
 * @var User $user
 * @author Alex Kireev <alexk984@gmail.com>
 */
Yii::app()->clientScript
    ->registerScript('file-upload2', 'var FileAPI = { debug: false, pingUrl: false }', CClientScript::POS_HEAD)
    ->registerScriptFile('/javascripts/upload/FileAPI.min.js', CClientScript::POS_BEGIN)
    ->registerScriptFile('/javascripts/upload/FileAPI.id3.js', CClientScript::POS_BEGIN)
    ->registerScriptFile('/javascripts/upload/FileAPI.exif.js', CClientScript::POS_BEGIN);

if (!empty($user->avatar_id) && !empty($user->avatar->userAvatar)) {
    $userAva = $user->avatar->userAvatar;
    $json = array(
        'image_url' => $userAva->source->getOriginalUrl(),
        'coordinates' => array(
            (int)$userAva->x,
            (int)$userAva->y,
            (int)($userAva->x + $userAva->w),
            (int)($userAva->y + $userAva->h),
        ),
        'width' => $userAva->source->width,
        'height' => $userAva->source->height,
        'source_id' => $user->avatar->userAvatar->source_id
    );
} else {
    $json = array(
        'image_url' => empty($user->avatar_id) ? null : $user->avatar->getOriginalUrl(),
        'coordinates' => array(),
        'width' => empty($user->avatar_id) ? 0 : $user->avatar->width,
        'height' => empty($user->avatar_id) ? 0 : $user->avatar->height,
        'source_id' => empty($user->avatar_id) ? 0 : $user->avatar->id,
    );
}

if (Yii::app()->user->id != $user->id):
    ?>
    <div class="b-ava-large">
        <div class="ava large">
            <img src="<?= $user->getAvatarUrl(200) ?>" alt=""/>
        </div>
        <?php if ($user->online): ?>
            <span class="b-ava-large_online">На сайте</span>
        <?php else: ?>
            <span class="b-ava-large_lastvisit">Была на сайте <br> <?= HDate::GetFormattedTime($user->login_date); ?></span>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="b-ava-large upload-avatar-vm">
            <a href="#popup-upload-ava" class="ava large fancy" data-theme="transparent" data-bind="click:load">
                <?php if (!empty($user->avatar_id)):?>
                    <img src="<?= $user->getAvatarUrl(200) ?>" alt=""/>
                    <span class="b-ava-large_photo-change">Изменить <br>главное фото</span>
                <?php else: ?>
                    <span class="b-ava-large_photo-add" data-bind="click:load">Добавить <br>главное фото</span>
                <?php endif ?>
            </a>

        <?php if ($user->online): ?>
            <span class="b-ava-large_online">На сайте</span>
        <?php else: ?>
            <span class="b-ava-large_lastvisit">Была на сайте <br> <?= HDate::GetFormattedTime($user->login_date); ?></span>
        <?php endif; ?>
        <a href="/user/settings/" class="b-ava-large_settings powertip" title="Настройки профиля"></a>
    </div>

    <div style="display: none;">
        <div id="popup-upload-ava" class="popup-upload-ava upload-avatar-vm">
            <a href="" class="popup-transparent-close powertip" data-bind="click: cancel" title="Закрыть"></a>

            <div class="clearfix">
                <div class="w-720">

                    <div class="b-settings-blue">
                        <div class="popup-upload-ava_t">Главное фото</div>
                        <div class="clearfix">
                            <div class="popup-upload-ava_left">
                                <div class="b-add-img b-add-img__for-single">
                                    <!-- ko if: status() == 0 -->
                                    <div class="b-add-img_hold">
                                        <div class="b-add-img_t">
                                            Загрузите фотографию с компьютера
                                            <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
                                        </div>
                                        <div class="file-fake">
                                            <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                                            <input class="js-upload-files" type="file" name="">
                                        </div>
                                    </div>
                                    <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
                                    <div class="b-add-img_desc">Загружайте пожалуйста свои фотографии, фото будут
                                        проверяться, <br> и если их содержание не будет соответствуют этике сайта, <br>
                                        будут удаляться
                                    </div>
                                    <!-- /ko -->

                                    <div class="js-image" style="opacity: 0.5" data-bind="visible: status() == 1"></div>

                                    <div class="b-add-img_i-vert" data-bind="visible: status() == 1"></div>
                                    <div class="b-add-img_i-load" data-bind="visible: status() == 1">
                                        <div class="b-add-img_i-load-progress"
                                             data-bind="style: {width: progress}"></div>
                                    </div>

                                    <img id="jcrop_target" src="" alt=""
                                         data-bind="attr: {src: image_url()}, visible: status() == 2"/>

                                </div>
                            </div>
                            <div class="popup-upload-ava_right">
                                <div class="popup-upload-ava_t">Просмотр</div>
                                <div class="popup-upload-ava_prev">
                                    <div class="b-ava-large">
                                        <div class="ava large">
                                            <img id="preview" src="" alt="" data-bind="attr: {src: image_url()}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="color-gray font-small">Так будет выглядеть ваше главное фото на страницах
                                    сайта
                                </div>
                            </div>
                        </div>
                        <div class="textalign-c margin-t10 clearfix">
                            <a class="btn-gray-light btn-h46 margin-r15" href="" data-bind="click: cancel">Отменить</a>
                            <a class="btn-blue btn-h46" href=""
                               data-bind="click: save, css: {'btn-inactive': status() != 2}">Сохранить</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    var UserAva = function (data) {
        var self = this;
        self.file = ko.observable(null);
        self.image_url = ko.observable(data.image_url);
        self.old_url = ko.observable(self.image_url());
        self.id = ko.observable(data.source_id);
        self.status = ko.observable(0);
        self._progress = ko.observable(0);

        self.jcrop_api = null;
        self.width = data.width;
        self.height = data.height;
        self.coordinates = data.coordinates;

        self.load = function () {
            if (self.image_url()) {
                self.status(2);
                $('#jcrop_target').Jcrop({
                    trueSize: [self.width, self.height],
                    onChange: self.showPreview,
                    onSelect: self.showPreview,
                    aspectRatio: 1,
                    boxWidth: 438,
                    minSize: [200, 200]
                }, function () {
                    self.jcrop_api = this;
                });

                if (self.coordinates.length > 0) {
                    setTimeout(function () {
                        self.jcrop_api.setSelect(self.coordinates);
                    }, 200);
                }
            }
        };

        self.save = function () {
            $.post('/profile/setAvatar/', {source_id: self.id, coordinates: self.coordinates}, function (response) {
                if (response.status) {
                    window.location.reload();
                }
            }, 'json');
        };
        self.cancel = function () {
            self.image_url(self.old_url());
            $.fancybox.close();
            window.setTimeout(function(){
                self.status(0);
                if (self.jcrop_api != null)
                    self.jcrop_api.destroy();
            }, 500);
        };
        self.onFiles = function (files) {
            FileAPI.each(files, function (file) {
                if (file.size >= 6 * FileAPI.MB)
                    alert('Размер файла больше 6Мб');
                else if (file.size === void 0)
                    alert('Ошибка получения файла');
//                else if (info.width < 438)
//                    alert('Слишком маленькое фото');
                else
                    self.upload(file);
            });
        };

        self.showPreview = function (coordinates) {
            self.coordinates = coordinates;
            var rx = 200 / coordinates.w;
            var ry = 200 / coordinates.h;

            $('#preview').css({
                width: Math.round(rx * self.width) + 'px',
                height: Math.round(ry * self.height) + 'px',
                marginLeft: '-' + Math.round(rx * coordinates.x) + 'px',
                marginTop: '-' + Math.round(ry * coordinates.y) + 'px'
            });
        };

        self.upload = function (file) {
            self.status(0);
            self.file(file);
            FileAPI.Image(self.file()).resize(438, 1000, 'max').get(function (err, img) {
                $('#popup-upload-ava .js-image').prepend(img);
            });

            if (self.jcrop_api !== null)
                self.jcrop_api.destroy();

            self.file().xhr = FileAPI.upload({
                url: '/ajaxSimple/uploadPhoto/',
                imageAutoOrientation: true,
                files: { file: self.file() },
                upload: function () {
                    self.status(1);
                },
                progress: function (evt) {
                    var percent = evt.loaded / evt.total * 100;
                    self._progress(percent);
                },
                complete: function (err, xhr) {
                    var response = $.parseJSON('[' + xhr.response + ']')[0];
                    self.width = response.width;
                    self.height = response.height;
                    self.id(response.id);
                    self.image_url(response.image_url);

                    setTimeout(function () {
                        //$('#jcrop_target').load(function () {
                        self._progress(100);
                        self.status(2);
                        $('#jcrop_target').Jcrop({
                            setSelect: [200, 200, 120, 120],
                            trueSize: [self.width, self.height],
                            onChange: self.showPreview,
                            onSelect: self.showPreview,
                            aspectRatio: 1,
                            boxWidth: 438,
                            minSize: [200, 200]
                        }, function () {
                            self.jcrop_api = this;
                        });
                        //});
                    }, 200);
                }
            });
        };

        self.progress = ko.computed(function () {
            return self._progress() + '%';
        });

        if (FileAPI.support.dnd) {
            $('.b-add-img_html5-tx').show();
            $('#popup-upload-ava .b-add-img').dnd(function (over) {
            }, function (files) {
                self.onFiles(files);
            });
        }
        $('#popup-upload-ava .js-upload-files').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            self.onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });

        $.each($('.b-add-img'), function () {
            $(this)[0].ondragover = function () {
                $('.b-add-img').addClass('dragover')
            };
            $(this)[0].ondragleave = function () {
                $('.b-add-img').removeClass('dragover')
            };
        });

    };

    var vm = new UserAva(<?=CJSON::encode($json)?>);
    $(".upload-avatar-vm").each(function (index, el) {
        ko.applyBindings(vm, el);
    });
</script>
<style type="text/css">
    #popup-upload-ava img {
        max-width: none !important;
    }
</style>