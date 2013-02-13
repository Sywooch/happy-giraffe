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
            <?php $this->renderPartial('_forecast_menu',array('model'=>$model))?>
        </div>

        <div class="text clearfix">
            <div class="date">
                <span><?=date("j", strtotime($model->date)) ?></span>
                <?=HDate::ruMonthShort(date("n", strtotime($model->date)))?>
            </div>
            <div class="holder">
                <?php if (Yii::app()->controller->action->id != 'date' ) $this->beginWidget('SeoContentWidget'); ?>
                <?=Str::strToParagraph($model->text) ?>
                <?php if (Yii::app()->controller->action->id != 'date' ) $this->endWidget(); ?>
                <p><?=$model->getAdditionalText() ?></p>

                <?php if (Yii::app()->controller->action->id == 'date' ):?>
                <div class="dates clearfix">
                    <?php $prev = strtotime('-1 day',strtotime($model->date)); ?>
                    <?php if ($model->dateHoroscopeExist($prev)):?>
                        <span class="a-left"><?=$model->getDateLink($prev) ?> ←</span>
                    <?php endif ?>
                    <?php $next = strtotime('+1 day',strtotime($model->date)); ?>
                    <?php if ($model->dateHoroscopeExist($next)):?>
                    <span class="a-right">→ <?=$model->getDateLink($next) ?></span>
                    <?php endif ?>


                    <?php $prev = strtotime('-2 days',strtotime($model->date)); ?>
                    <?php if ($model->dateHoroscopeExist($prev)):?>
                    <span class="a-left"><?=$model->getDateLink($prev) ?> ←</span>
                    <?php endif ?>

                    <?php $next = strtotime('+2 days',strtotime($model->date)); ?>
                    <?php if ($model->dateHoroscopeExist($next)):?>
                    <span class="a-right">→ <?=$model->getDateLink($next) ?></span>
                    <?php endif ?>
                </div>
                <?php endif ?>
            </div>
        </div>

        <?php if (Yii::app()->controller->action->id == 'yesterday' ):?>
            <div class="horoscope-daylist clearfix">
                <ul>
                    <?php for ($i=2;$i<10;$i++): ?>
                        <li><?=$model->getDateLink(strtotime('-'.$i.' days')) ?></li>
                    <?php endfor; ?>
                </ul>
            </div>
        <?php endif ?>

        <?php $this->renderPartial('likes_simple',array('model'=>$model)) ?>

    </div>

</div>

<?php $this->renderPartial('_bottom_list',array('model'=>$model)); ?>

<?php if (Yii::app()->controller->action->id != 'date' ):?>
<div class="wysiwyg-content">

    <?=$model->getText(); ?>

</div>
<?php endif ?>

<div class="horoscope-otherday">
    <?=$model->getDateLinks() ?>
</div>
