<?php $time = strtotime($model->date);
?><h1><?=$this->title ?></h1>
<div class="horoscope-one">

    <div class="clearfix">
        <div class="right">

            <div class="date">
                <?php
                if (date("Y-m-d") == $model->date)
                    echo '<big>Гороскоп<br>на сегодня</big>';
                elseif (date("Y-m-d") == date("Y-m-d", strtotime('-1 day', strtotime($model->date))))
                    echo '<big>Гороскоп<br>на завтра</big>';
                elseif (date("Y-m-d") == date("Y-m-d", strtotime('+1 day', strtotime($model->date))))
                    echo '<big>Гороскоп<br>на вчера</big>';
                else
                    echo '<big>Гороскоп<br>на</big>';
                ?>
                <span><span><?=date("j", strtotime($model->date)) ?></span><?=Yii::app()->dateFormatter->format('MMM',strtotime($model->date))  ?></span>
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

    <?=HoroscopeText::getDateText($model->zodiac, $model->date); ?>

</div>

<?php $this->renderPartial('_bottom_list',array('model'=>$model)); ?>
