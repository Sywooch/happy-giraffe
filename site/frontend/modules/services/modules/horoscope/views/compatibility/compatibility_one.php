<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <div class="b-main_col-article">

            <h1 class="heading-link-xxl">Гороскоп совместимости - <?= Horoscope::model()->zodiac_list[$model->zodiac1] . ' и ' . Horoscope::model()->zodiac_list[$model->zodiac2] ?></h1>
            <div class="horoscope-compatibility">
                <div class="ico-zodiac ico-zodiac__m ico-zodiac__l-xs ico-zodiac__xl-sm">
                    <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac1 ?>"></div>
                </div><span class="horoscope-compatibility_plus"></span>
                <div class="ico-zodiac ico-zodiac__m ico-zodiac__l-xs ico-zodiac__xl-sm">
                    <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac2 ?>"></div>
                </div>
            </div>
            <div class="wysiwyg-content clearfix">
                <?php if (!empty($model->text)) echo $model->text; ?>
            </div>
            <!-- Лайки от янжекса-->
            <div class="custom-likes">
                <div class="custom-likes_slogan">Вам понравился гороскоп?
                </div>
                <div class="custom-likes_in">
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div data-yasharel10n="ru" data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yasharetheme="counter" data-yasharetype="small" class="yashare-auto-init"></div>
                </div>
            </div>
            <!-- Лайки от янжекса-->
            <div class="horoscope-compatibility-list horoscope-compatibility-list__center visible-md-block textalign-c">
                <div class="horoscope-compatibility-list_t">Другие совместимости</div>
                <ul class="horoscope-compatibility-list_ul">
                    <?php $this->renderPartial('_compatibility_links', array('zodiac' => $model->zodiac1)); ?>
                    <?php
                    if ($model->zodiac1 != $model->zodiac2)
                        $this->renderPartial('_compatibility_links', array('zodiac' => $model->zodiac2));
                    ?>
                </ul>
            </div>
            <!-- Реклама яндекса-->
            <?php $this->renderPartial('//banners/_horoscope'); ?>
        </div>
    </div>
</div>
