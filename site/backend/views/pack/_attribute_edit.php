<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Attribute
 */
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'attribute-form',
    'enableAjaxValidation' => false,
)); ?>

<p class="row">
    <?php echo $form->textField($model, 'attribute_title', array('size' => 50, 'maxlength' => 50)); ?>
    <?php echo $form->dropDownList($model, 'attribute_type', $model->types->statuses); ?>
</p>

<p class="row">
    <?php echo $form->label($model, 'attribute_required'); ?>
    <?php echo $form->checkBox($model, 'attribute_required', array('class' => 'niceCheck')); ?>
</p>

<p class="row">
    <?php echo $form->label($model, 'attribute_is_insearch'); ?>
    <?php echo $form->checkBox($model, 'attribute_is_insearch', array('class' => 'niceCheck')); ?>
</p>

<p class="row">
    <?php echo $form->label($model, 'price_influence'); ?>
    <?php echo $form->checkBox($model, 'price_influence', array('class' => 'niceCheck')); ?>
</p>

<p class="row buttons">
    <?php echo CHtml::submitButton('OK'); ?>
</p>

<?php $this->endWidget(); ?>