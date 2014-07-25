<?php
/**
 * @var $model Horoscope
 */
?><?php $time = strtotime($model->date);?>
<div class="horoscope-one">

    <div class="block-in">

        <div class="img">

            <div class="in"><img src="/images/widget/horoscope/big/<?=$model->zodiac ?>.png"></div>
            <div class="date"><span><?=$model->zodiacText() ?></span><?=$model->zodiacDates() ?></div>

        </div>

        <div class="dates">
            <?php $this->renderPartial('_forecast_menu',array('model'=>$model))?>
        </div>

        <div class="text clearfix">
            <div class="date">
                <span><?=date("j", strtotime($model->date)) ?></span>
                <?=HDate::ruMonthShort(date("n", strtotime($model->date)))?>
            </div>
            <?php $this->beginWidget('SeoContentWidget'); ?>
            <div class="holder"><?=Str::strToParagraph($model->text) ?></div>
            <?php $this->endWidget(); ?>
        </div>

        <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'title' => $this->social_title)); ?>

    </div>

</div>

<?php $this->renderPartial('_bottom_list',array('model'=>$model)); ?>

<div class="wysiwyg-content">

    <?=$model->getText(); ?>

</div>

<div class="horoscope-otherday">
    <?=$model->getDateLinks() ?>
</div>