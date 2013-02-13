<?php
/**
 * @var $model Horoscope
 */
$data = $model->CalculateMonthData();
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
                <span class="year"><?=HDate::ruMonthShort($model->month)?></span>
                <?=$model->year?>
            </div>

            <?php if (empty($_GET['month'])) $this->beginWidget('SeoContentWidget'); ?>
            <div class="holder">
                <?=Str::strToParagraph($model->text) ?>
                <p><?=$model->getAdditionalText() ?></p>
            </div>
            <?php if (empty($_GET['month'])) $this->endWidget(); ?>

        </div>

        <div class="horoscope-month clearfix">

            <?php if (empty($_GET['month'])) $this->beginWidget('SeoContentWidget'); ?>
            <table cellpadding="0" cellspacing="0">
                <tbody>
                <?php $i = 0;
                    foreach ($data as $cell) {
                    if ($i % 7 == 0 && $i != 0 && count($data) != $i)
                        echo "</tr><tr>";
                    $i++;?>
                    <td><span class="day<?php if (!empty($cell[1])) echo ' '.$cell[1] ?>"><?=$cell[0] ?></span></td>
                <?php } ?>
                </tbody>
            </table>
            <?php if (empty($_GET['month'])) $this->endWidget(); ?>

            <div class="legend">
                <div class="row">
                    <span class="day good"></span> - благоприятные дни
                </div>
                <div class="row">
                    <span class="day bad"></span> - неблагоприятные дни
                </div>
            </div>
        </div>

        <?php $this->renderPartial('likes_simple',array('model'=>$model)) ?>

    </div>

</div>

<?php $this->renderPartial('_bottom_list',array('model'=>$model)); ?>

<?php if (empty($_GET['month'])):?>
    <div class="wysiwyg-content">

        <?=$model->getText(); ?>

    </div>
<?php endif ?>

<div class="horoscope-otherday">
<?php if ($model->isCurrentMonth()) {?>
    А еще:
    <div class="row">
        <?=$model->getPrevMonthLink() ?>
        <?=$model->getNextMonthLink() ?>
        <?=$model->getNextMonthLink(2) ?>
        <?=$model->getNextMonthLink(3) ?>
        <?=$model->getNextMonthLink(4) ?>
        <?=$model->getNextMonthLink(5) ?>
    </div>
<?php }else{ ?>
    А еще гороскоп:
    <div class="row">
        <?=$model->getPrevMonthLink() ?>
        <?=$model->getNextMonthLink() ?>
    </div>
<?php } ?>
</div>
