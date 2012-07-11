<?php
/* @var $this Controller
 * @var $model Horoscope
 */
?><li>
    <div class="img">
        <img src="/images/widget/horoscope/small/<?=$model->zodiac ?>.png">
        <div class="date"><span><?=$model->zodiacText() ?></span><?=$model->zodiacDates() ?></div>
    </div>
    <div class="text"><?= Str::truncate($model->text, 230, '') ?> <a href="<?=$this->createUrl('view', array('zodiac'=>Horoscope::getZodiacSlug($model->zodiac))) ?>">далее</a></div>
</li>