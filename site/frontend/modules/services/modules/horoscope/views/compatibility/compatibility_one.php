<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */
$this->pageTitle = 'Гороскоп совместимости знаков';
$this->breadcrumbs = array(
    'Гороскопы' => array('/services/horoscope/default/index'),
    'Совместимость' => '/horoscope/compatibility/',
    Horoscope::model()->zodiac_list[$model->zodiac1] . ' - ' . Horoscope::model()->zodiac_list[$model->zodiac2],
);
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
            <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'lite' => true, 'widgetTitle' => 'Вам понравился гороскоп?')); ?> 
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
            <?php $this->renderPartial('//banners/_direct_others'); ?>
        </div>
    </div>
</div>
