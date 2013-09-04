<?php
/**
 * @var User $user
 * @author Alex Kireev <alexk984@gmail.com>
 */
Yii::app()->clientScript
    ->registerPackage('ko_upload');

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
            <img src="<?= $user->getAvatarUrl(Avatar::SIZE_LARGE) ?>" alt=""/>
        </div>
        <?php if ($user->online): ?>
            <span class="b-ava-large_online">На сайте</span>
        <?php else: ?>
            <span class="b-ava-large_lastvisit">Была на сайте <br> <?= HDate::GetFormattedTime($user->login_date); ?></span>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="b-ava-large">
        <a href="#popup-upload-ava" class="ava <?= $user->gender == 1 ? 'male' : 'female' ?> large fancy" data-bind="click:load">
            <?php if (!empty($user->avatar_id)):?>
                <img src="<?= $user->getAvatarUrl(Avatar::SIZE_LARGE) ?>" alt=""/>
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
        <div id="popup-upload-ava" class="popup-upload-ava">
            <a href="" class="popup-transparent-close powertip" data-bind="click: cancel" title="Закрыть"></a>

            <div class="clearfix">
                <div class="w-720">

                    <div class="b-settings-blue" id="upload_ava_block">
                        <div class="popup-upload-ava_t">Главное фото</div>
                        <div class="clearfix">
                            <div class="popup-upload-ava_left">
                                <div class="b-add-img b-add-img__for-single">

                                    <div data-bind="visible: status() == 0">
                                        <div class="b-add-img_hold">
                                            <div class="b-add-img_t">
                                                Загрузите фотографию с компьютера
                                                <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
                                            </div>
                                            <div class="file-fake">
                                                <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                                                <input class="js-upload-files-multiple" type="file">
                                            </div>
                                        </div>
                                        <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
                                        <!--<div class="b-add-img_desc">Загружайте пожалуйста свои фотографии, фото будут
                                            проверяться, <br> и если их содержание не будет соответствуют этике сайта, <br>
                                            будут удаляться
                                        </div>-->
                                    </div>

                                    <div class="b-add-img_i-vert" data-bind="visible: status() == 1"></div>
                                    <div class="b-add-img_i-load" data-bind="visible: status() == 1">
                                        <div class="b-add-img_i-load-progress" data-bind="style: {width: progress}"></div>
                                    </div>

                                    <img id="jcrop_target" src=""  data-bind="attr: {src: image_url()}, visible: status() == 2"/>

                                    <a href="" class="b-add-img_i-del ico-close2 powertip" data-bind="click: remove, visible: status() == 2" title="Удалить фото"></a>

                                </div>
                            </div>
                            <div class="popup-upload-ava_right">
                                <div class="popup-upload-ava_t">Просмотр</div>
                                <div class="popup-upload-ava_prev">
                                    <div class="b-ava-large">
                                        <div class="ava <?= $user->gender == 1 ? 'male' : 'female' ?> large">
                                            <img id="preview" src="" alt="" data-bind="attr: {src: image_url()}, visible: status() == 2"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="color-gray font-small">Так будет выглядеть ваше фото на страницах сайта</div>
                            </div>
                        </div>
                        <div class="textalign-c margin-t10 clearfix">
                            <a class="btn-gray-light btn-h46 margin-r15" href="" data-bind="click: cancel">Отменить</a>
                            <a class="btn-blue btn-h46" href="" data-bind="click: save, css: {'btn-inactive': status() != 2}">Сохранить</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    var vm = new UserAva(<?=CJSON::encode($json)?>, '#popup-upload-ava');
    ko.applyBindings(vm, document.getElementById('#popup-upload-ava'));
</script>
<style type="text/css">
    #popup-upload-ava img {
        max-width: none !important;
    }
</style>