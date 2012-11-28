<?php
/* @var $this Controller
 * @var $model Horoscope
 */
if (isset($model)){
?><li><div class="img clearfix">
        <img src="/images/widget/horoscope/small/<?=$model->zodiac ?>.png">
        <div class="date"><a href="<?=$this->createUrl($model->getType(), array('zodiac'=>$model->getZodiacSlug())) ?>"><?=$model->zodiacText() ?></a>
            <?=$model->zodiacDates() ?></div>
    </div>
    <div class="text">
        <?= Str::truncate($model->getForecastText(), 230, '&hellip;') ?>
        <?=HHtml::link('узнать', $this->createUrl($model->getType(), array('zodiac'=>$model->getZodiacSlug())), array('class'=>'btn-green btn-small'), true);?>
    </div>
</li><?php }