<?php
/* @var $this Controller
 * @var $model Horoscope
 */
if (isset($model)){
?><li><div class="img">
        <img src="/images/widget/horoscope/small/<?=$model->zodiac ?>.png">
        <div class="date"><a href="<?=$this->createUrl($model->getType(), array('zodiac'=>$model->getZodiacSlug())) ?>"><?=$model->zodiacText() ?></a>
            <?=$model->zodiacDates() ?></div>
    </div>
    <div class="text">
        <?= Str::truncate($model->getForecastText(), 230, '&hellip;') ?>
        <a class="btn-green btn-small" href="<?=$this->createUrl($model->getType(), array('zodiac'=>$model->getZodiacSlug())) ?>">узнать</a></div>
</li><?php }