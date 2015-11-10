<?php
/**
 * @var site\frontend\modules\som\modules\qa\models\QaQuestion $model
 * @var site\frontend\components\requirejsHelpers\ActiveForm $form
 */
?>

<?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'focus'=>array($model,'firstName'),
)); ?>

<div class="row">
    <?php echo $form->textField($model, 'title'); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div class="row">
    <?php echo $form->textArea($model, 'text'); ?>
    <?php echo $form->error($model, 'text'); ?>
</div>

<div class="row">
    <?php echo $form->dropDownList($model, 'categoryId', CHtml::listData(\site\frontend\modules\som\modules\qa\models\QaCategory::model()->simple()->findAll(), 'id', 'title')); ?>
    <?php echo $form->error($model, 'categoryId'); ?>
</div>

<div class="row">
    <?php echo $form->checkBox($model, 'sendNotifications'); ?>
    <?php echo $form->error($model, 'sendNotifications'); ?>
</div>

<input type="submit">

<?php $this->endWidget(); ?>