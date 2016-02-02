<?php
/**
 * @var string $activePeriodId
 */
Yii::app()->clientScript->registerAMD('bootstrap', array('bootstrap'));
?>

<div class="rating-widget">
    <div class="rating-widget_heading">Рейтинг</div><a class="rating-widget_heading_link" href="<?=Yii::app()->controller->createUrl('/som/qa/rating/index')?>">Весь рейтинг</a>
    <div class="clearfix"></div>
    <ul class="rating-widget_filter filter-menu nav nav-tabs">
        <?php foreach (Yii::app()->controller->module->periods as $periodId => $periodData): ?>
            <?php if (count($models[$periodId]) > 0):?>
                <li class="filter-menu_item <?=($activePeriodId == $periodId) ? 'active' : ''?>"><a data-toggle="tab" class="filter-menu_item_link" href="#rating-tab-<?=$periodId?>"><?=$periodData['label']?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="clearfix"></div>
    </ul>
    <div class="tab-content">
        <?php foreach (Yii::app()->controller->module->periods as $periodId => $periodData): ?>
            <div class="tab-pane<?=($activePeriodId == $periodId) ? ' active' : ''?>" id="rating-tab-<?=$periodId?>">
                <ul class="rating-widget_users-list">
                    <?php foreach ($models[$periodId] as $model): ?>
                        <?php $this->render('_row', compact('model')); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>