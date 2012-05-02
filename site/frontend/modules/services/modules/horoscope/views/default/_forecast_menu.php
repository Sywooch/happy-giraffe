<?php
/* @var $this Controller
 * @var $model Horoscope
 */
?><div class="right">

    <div class="forecast">

        <big>Прогноз:</big>

        <ul>
            <li<?php if ($model->date == date("Y-m-d", strtotime('-1 day'))) echo ' class="active"' ?>><a href="<?=$this->createUrl('/horoscope/default/view', array('zodiac'=>$model->zodiacText(),'date'=>date("Y-m-d", strtotime('-1 day')))) ?>">на вчера</a></li>
            <li<?php if ($model->date == date("Y-m-d")) echo ' class="active"' ?>><a href="<?=$this->createUrl('/horoscope/default/view', array('zodiac'=>$model->zodiacText())) ?>">на сегодня</a></li>
            <li<?php if ($model->date == date("Y-m-d", strtotime('+1 day'))) echo ' class="active"' ?>><a href="<?=$this->createUrl('/horoscope/default/view', array('zodiac'=>$model->zodiacText(),'date'=>date("Y-m-d", strtotime('+1 day')))) ?>">на завтра</a></li>
            <li<?php if ($model->onMonth()) echo ' class="active"' ?>><a href="<?=$this->createUrl('/horoscope/default/month', array('zodiac'=>$model->zodiacText())) ?>">на месяц</a></li>
            <li class="year<?php if ($model->onYear()) echo ' active' ?>"><a href="<?=$this->createUrl('/horoscope/default/year', array('zodiac'=>$model->zodiacText())) ?>">на 2012</a></li>
        </ul>

    </div>

</div>

<div class="left">

    <div class="text">

        <?=$model->getFormattedText() ?>

    </div>

</div>