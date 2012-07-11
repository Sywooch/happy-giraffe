<?php
/* @var $this Controller
 * @var $model Horoscope
 */
?><div class="right">

    <div class="forecast">

        <big>Прогноз:</big>

        <ul>
            <li<?php if ($model->date == date("Y-m-d", strtotime('-1 day'))) echo ' class="active"' ?>><a href="<?=$this->createUrl('yesterday', array('zodiac'=>Horoscope::getZodiacSlug($model->zodiac))) ?>">на вчера</a></li>
            <li<?php if ($model->date == date("Y-m-d")) echo ' class="active"' ?>><a href="<?=$this->createUrl('view', array('zodiac'=>Horoscope::getZodiacSlug($model->zodiac))) ?>">на сегодня</a></li>
            <li<?php if ($model->date == date("Y-m-d", strtotime('+1 day'))) echo ' class="active"' ?>><a href="<?=$this->createUrl('tomorrow', array('zodiac'=>Horoscope::getZodiacSlug($model->zodiac))) ?>">на завтра</a></li>
            <li<?php if ($model->onMonth()) echo ' class="active"' ?>><a href="<?=$this->createUrl('month', array('zodiac'=>Horoscope::getZodiacSlug($model->zodiac))) ?>">на месяц</a></li>
            <li class="year<?php if ($model->onYear()) echo ' active' ?>"><a href="<?=$this->createUrl('year', array('zodiac'=>Horoscope::getZodiacSlug($model->zodiac))) ?>">на 2012</a></li>
        </ul>

    </div>

</div>

<div class="left">

    <div class="text">

        <?=$model->getFormattedText() ?>

    </div>

</div>