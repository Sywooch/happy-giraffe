<?php
/* @var $this HController
 * @var $models Horoscope[]
 */
?>
<div class="horoscope-list">

    <h1><?=$this->title ?></h1>

    <ul><?php
        if ($year == 2012)
            foreach ($models as $model)
                $this->renderPartial('_preview', compact('model'));
        else
            foreach ($models as $model)
                if (isset($model)){
                    ?><li><div class="img">
                        <img src="/images/widget/horoscope/small/<?=$model->zodiac ?>.png">
                        <div class="date"><a href="<?=$this->createUrl('year', array('zodiac'=>$model->getZodiacSlug(), 'year'=>$model->year)) ?>"><?=$model->zodiacText() ?></a>
                            <?=$model->zodiacDates() ?></div>
                    </div>
                        <div class="text">
                            <?= Str::truncate($model->getForecastText(), 230, '&hellip;') ?>
                            <?=HHtml::link('узнать', $this->createUrl('year', array('zodiac'=>$model->getZodiacSlug(), 'year'=>$model->year)), array('class'=>'btn-green btn-small'), true);?>
                        </div>
                    </li><?php
        } ?></ul>

</div>

<div class="wysiwyg-content">

    <?=ServiceText::getText('horoscope', 'year') ?>

</div>