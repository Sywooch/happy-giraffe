<?php
/**
 * @var $model Horoscope
 */
?><?php $time = strtotime($model->date); ?>
<div class="b-main_cont">
    <div class="b-main_col-article">
        <h1 class="heading-link-xxl"><?= '' ?></h1>
        <div class="horoscope-day">
            <div class="ico-zodiac ico-zodiac__xl">
                <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
            </div>
            <div class="horoscope-day_tx"><?= $model->zodiacText() ?></div>
        </div>
        <div class="wysiwyg-content clearfix">
            <?php
            if (Yii::app()->controller->action->id != 'date')
            {
                $this->beginWidget('SeoContentWidget');
                echo Str::strToParagraph($model->text);
                $this->endWidget();
            }
            ?>
            <p><?= $model->getAdditionalText() ?></p>
        </div>
        <!-- Лайки от янжекса-->
        <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'title' => $this->social_title)); ?>

        <div class="menu-link-simple menu-link-simple__center">
            <div class="menu-link-simple_t">Еще Овен</div>
            <?php $this->renderPartial('_menu'); ?>
        </div>
        <div class="seo-desc wysiwyg-content visible-md-block">
            <?= $model->getText(); ?>
        </div>
        <!-- Реклама яндекса-->
        <?php $this->renderPartial('//banners/_horoscope'); ?>
    </div>
    <!-- /Основная колонка-->
    <div class="b-main_col-sidebar">
        <!-- Зодиаки-->
        <div class="zodiac-list zodiac-list__sidebar">
            <?php $this->renderPartial('_zodiac_list'); ?>
        </div>
        <!-- Зодиаки-->
    </div>
</div>
