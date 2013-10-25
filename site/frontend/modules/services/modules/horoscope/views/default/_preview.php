<?php
/* @var $this Controller
 * @var $model Horoscope
 */
if (isset($model)){ ?>

    <li class="horoscopes-big_i">

        <div class="horoscopes-big_img">
            <img src="/images/widget/horoscope/big/<?=$model->zodiac ?>.png" alt="">
        </div>
        <a href="<?=$model->getMainUrl() ?>" class="horoscopes-big_t"><?=$model->zodiacText() ?></a>
        <div class="horoscopes-big_time"><?=$model->zodiacDates() ?></div>

        <div class="horoscopes-big_hold">
            <div class="clearfix">
                <span class="horoscopes-big_t-sub"><?=$model->zodiacText() ?></span>
                <span class="horoscopes-big_time-sub"><?=$model->zodiacDates() ?></span>
            </div>
            <div class="horoscopes-big_desc"><?= Str::truncate($model->getForecastText(), 200) ?></div>
            <div class="clearfix textalign-c">
                <?=HHtml::link('Весь гороскоп', $model->getMainUrl(), array('class'=>'horoscopes-big_btn btn-green btn-medium'), true) ?>
            </div>
        </div>
    </li>

<?php }