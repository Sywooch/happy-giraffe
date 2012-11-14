<?php
/**
 * @var $model Horoscope
 */
?><?php $time = strtotime($model->date);?>
<div class="horoscope-one">

    <div class="block-in">

        <h1><?=$this->title ?></h1>

        <div class="img">

            <div class="in"><img src="/images/widget/horoscope/big/<?=$model->zodiac ?>.png"></div>
            <div class="date"><span><?=$model->zodiacText() ?></span><?=$model->zodiacDates() ?></div>

        </div>

        <div class="dates">
            <?php $this->renderPartial('_forecast_menu', array('model' => $model))?>
        </div>

        <div class="horoscope-year">
            <div class="horoscope-year_item health">
                <p><span class="red">Здоровье.</span> <?=$model->health ?></p>
            </div>
            <div class="horoscope-year_item career">
                <p><span class="red">Карьера.</span> <?=$model->career ?></p>
            </div>
            <div class="horoscope-year_item fin">
                <p><span class="red">Финансы.</span> <?=$model->finance ?></p>
            </div>
            <div class="horoscope-year_item home">
                <p><span class="red">Личная жизнь.</span> <?=$model->personal ?></p>
            </div>
        </div>

        <?php $this->renderPartial('_likes', compact('model')); ?>

    </div>

</div>

<?php $this->renderPartial('_bottom_list', array('model' => $model)); ?>

<div class="wysiwyg-content">

    <?=$model->getText(); ?>

</div>

<div class="horoscope-otherday">
    <?php if ($model->isCurrentYear()) {?>
    А еще гороскоп <?=$model->zodiacText() ?> на:
    <div class="row">
        <span>→ <?=$model->getNextYearLink() ?></span>
    </div>
    <?php }else{ ?>
    А еще гороскоп <?=$model->zodiacText() ?> на:
    <div class="row">
        <span><?=$model->getPrevYearLink() ?> ←</span>
        <span>→ <?=$model->getNextYearLink() ?></span>
    </div>
    <?php } ?>
</div>
