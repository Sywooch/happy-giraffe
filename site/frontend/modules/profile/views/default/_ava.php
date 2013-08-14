<?php
/**
 * @var User $user
 * @author Alex Kireev <alexk984@gmail.com>
 */

if (Yii::app()->user->id != $user->id):
?><div class="b-ava-large">
    <div class="ava large">
        <img src="/images/example/ava-large.jpg" alt="">
    </div>
    <?php if ($user->online): ?>
        <span class="b-ava-large_online">На сайте</span>
    <?php else: ?>
        <span class="b-ava-large_lastvisit">Была на сайте <br> <?= HDate::GetFormattedTime($user->login_date); ?></span>
    <?php endif; ?>
</div>
<?php else: ?>
    <div class="b-ava-large">
        <a href="#popup-upload-ava" class="ava large fancy" data-theme="transparent" >
            <img src="/images/example/ava-large.jpg" alt="">
            <span class="b-ava-large_photo-change">Изменить <br>главное фото</span>
        </a>
        <span class="b-ava-large_online">На сайте</span>
        <a href="" class="b-ava-large_settings powertip" title="Настройки профиля"></a>
    </div>

    <div style="display: none;">
        <div id="popup-upload-ava" class="popup-upload-ava">
            <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
            <div class="clearfix">
                <div class="w-720">

                    <div class="b-settings-blue">
                        <div class="popup-upload-ava_t">Главное фото</div>
                        <div class="clearfix">
                            <div class="popup-upload-ava_left">
                                <div class="b-add-img b-add-img__for-single">
                                    <div class="b-add-img_hold">
                                        <div class="b-add-img_t">
                                            Загрузите фотографию с компьютера
                                            <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
                                        </div>
                                        <div class="file-fake">
                                            <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                                            <input type="file" name="">
                                        </div>
                                    </div>
                                    <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
                                    <div class="b-add-img_desc">Загружайте пожалуйста свои фотографии, фото будут проверяться, <br> и если их содержание не будет соответствуют этике сайта, <br> будут удаляться</div>
                                </div>
                            </div>
                            <div class="popup-upload-ava_right">
                                <div class="popup-upload-ava_t">Просмотр</div>
                                <div class="popup-upload-ava_prev">
                                    <div class="b-ava-large">
                                        <div class="ava large">
                                            <img src="/images/example/w440-h340.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="color-gray font-small">Так будет выглядеть ваше главное фото на  страницах сайта</div>
                            </div>
                        </div>
                        <div class="textalign-c margin-t10 clearfix">
                            <a class="btn-gray-light btn-h46 margin-r15" href="">Отменить</a>
                            <a class="btn-blue btn-h46 btn-inactive" href="">Сохранить</a>
                        </div>

                    </div>

                    <div class="b-settings-blue">
                        <div class="popup-upload-ava_t">
                            Главное фото
                            <span class="font-small color-gray">(это фото также загрузится в ваш фотоальбом "Личные фотографии")</span>
                        </div>
                        <div class="clearfix">
                            <div class="popup-upload-ava_left">
                                <div class="b-add-img b-add-img__for-single">
                                    <div class="b-add-img_hold display-n">
                                        <div class="b-add-img_t">
                                            Загрузите фотографию с компьютера
                                            <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
                                        </div>
                                        <div class="file-fake">
                                            <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                                            <input type="file" name="">
                                        </div>
                                    </div>
                                    <div class="b-add-img_html5-tx display-n">или перетащите фото сюда</div>
                                    <div class="b-add-img_desc display-n">Загружайте пожалуйста свои фотографии, фото будут проверяться, <br> и если их содержание не будет соответствуют этике сайта, <br> будут удаляться</div>
                                    <img src="/images/example/w700-h740-1.jpg" alt="">
                                </div>
                            </div>
                            <div class="popup-upload-ava_right">
                                <div class="popup-upload-ava_t">Просмотр</div>
                                <div class="popup-upload-ava_prev">
                                    <div class="b-ava-large">
                                        <div class="ava large">
                                            <img src="/images/example/w700-h740-1.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="color-gray font-small">Так будет выглядеть ваше главное фото на  страницах сайта</div>
                            </div>
                        </div>
                        <div class="textalign-c margin-t10 clearfix">
                            <a class="btn-gray-light btn-h46 margin-r15" href="">Отменить</a>
                            <a class="btn-blue btn-h46" href="">Сохранить</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
<?php
    endif;