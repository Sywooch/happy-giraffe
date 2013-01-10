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

            <?php if (empty($_GET['year'])) $this->beginWidget('SeoContentWidget'); ?>

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

            <?php if (empty($_GET['year'])) $this->endWidget(); ?>

        </div>

        <?php $this->renderPartial('likes_simple',array('model'=>$model)) ?>

    </div>

</div>

<?php $this->renderPartial('_bottom_list', array('model' => $model)); ?>

<?php if (empty($_GET['year'])):?>
    <div class="wysiwyg-content">

        <?=$model->getText(); ?>

    </div>
<?php endif ?>

<div class="horoscope-otherday">
<?php if ($model->yearHoroscopeExist($model->year - 1) || $model->yearHoroscopeExist($model->year + 1)):?>
        А еще гороскоп:
        <div class="row">
            <?php if ($model->yearHoroscopeExist($model->year - 1)):?>
                <span><?=$model->getPrevYearLink() ?> ←</span>
            <?php endif ?>
            <?php if ($model->yearHoroscopeExist($model->year + 1)):?>
                <span>→ <?=$model->getNextYearLink() ?></span>
            <?php endif ?>
        </div>
<?php endif ?>
</div>
