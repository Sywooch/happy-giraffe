<?php $this->beginWidget('AdsWidget', array(
    'dummyTag' => 'google-tag',
    'show' => true,
    'lazyAdsOn' => false,
)); ?>
<?php Yii::app()->controller->renderPartial('//counters/_google_tag'); ?>
<?php $this->endWidget(); ?>
<?php $this->beginWidget('AdsWidget', array(
    'dummyTag' => 'yandex-metrika',
    'show' => Yii::app()->ads->isProduction(),
    'lazyAdsOn' => false,
)); ?>
<?php Yii::app()->controller->renderPartial('//counters/_metrika'); ?>
<?php $this->endWidget(); ?>
<?php $this->beginWidget('AdsWidget', array(
    'dummyTag' => 'piwik',
    'show' => Yii::app()->ads->isProduction(),
    'lazyAdsOn' => false,
)); ?>
<?=Yii::app()->getModule('analytics')->visitsManager->getTrackingCode()?>
<?php $this->endWidget(); ?>
<?php //Yii::app()->controller->renderPartial('//counters/_ga'); ?>
<?php //Yii::app()->controller->renderPartial('//counters/_top100'); ?>
<?=Yii::app()->getModule('analytics')->visitsManager->getTrackingCode()?>
