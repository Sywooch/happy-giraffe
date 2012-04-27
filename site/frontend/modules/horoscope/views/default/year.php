<h1><?=$this->title ?></h1>

<div class="horoscope-one">

    <div class="clearfix">
        <div class="right">

            <div class="date">
                <big>Гороскоп<br>на</big>
                <span><span><?=date('Y') ?></span>год</span>
            </div>

        </div>

        <div class="left">

            <div class="img">
                <div class="in"><img src="/images/widget/horoscope/big/<?=$model->zodiac ?>.png"></div>
                <div class="date"><span><?=$model->zodiacText() ?></span><?=$model->zodiacDates() ?></div>
            </div>

        </div>
    </div>
    <div class="clearfix">

        <?php $this->renderPartial('_forecast_menu',array('model'=>$model)); ?>

    </div>

</div>

<div class="wysiwyg-content">

    <?=HoroscopeText::getYearText($model->zodiac, $model->date); ?>

</div>

<?php $this->renderPartial('_bottom_list',array('model'=>$model)); ?>