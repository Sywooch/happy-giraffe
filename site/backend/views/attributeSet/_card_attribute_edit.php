<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Attribute
 */

$attribute_measure_selected = '';
$attribute_measure_options = array();
if ($model->attribute_type == Attribute::TYPE_MEASURE) {
    $attribute_measure_selected = $model->measure_option->measure_id;
    $attribute_measure_options = CHtml::listData($model->measure_option->measure->measureOptions, 'id', 'title');
}
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'attribute-form',
    'enableAjaxValidation' => false,
)); ?>
<?php echo CHtml::hiddenField('id', $model->attribute_id) ?>
<p class="row withMargin">
    <?php echo $form->textField($model, 'attribute_title', array('size' => 50, 'maxlength' => 50)); ?>
</p>
<p class="row withMargin">
    <?php echo $form->dropDownList($model, 'attribute_type', array(
    Attribute::TYPE_TEXT => 'Текст',
    Attribute::TYPE_MEASURE => 'Единицы измерения',
    Attribute::TYPE_BOOL => 'Да-Нет',
)); ?>
</p>

<p class="row withMargin"<?php if ($model->attribute_type != Attribute::TYPE_MEASURE) echo ' style="display: none;"' ?>>
    <?php echo CHtml::dropDownList('attribute_measure', $attribute_measure_selected, CHtml::listData(AttributeMeasure::model()->findAll(), 'id', 'title'), array('empty' => ' ')); ?>
</p>

<p class="row withMargin"<?php if ($model->attribute_type != Attribute::TYPE_MEASURE) echo ' style="display: none;"' ?>>
    <?php echo $form->dropDownList($model, 'measure_option_id', $attribute_measure_options); ?>
</p>

<?php if ($model->attribute_in_price == 1): ?>
<p class="row">
    <?php echo $form->label($model, 'price_influence'); ?>
    <?php echo $form->checkBox($model, 'price_influence', array('class' => 'niceCheck')); ?>
</p>
<?php endif ?>

<?php echo $form->hiddenField($model, 'attribute_in_price'); ?>

<p class="row buttons withMargin">
    <?php echo CHtml::submitButton('OK', array('class' => $model->isNewRecord ? 'add_attr_btn' : 'edit_attr_btn')); ?>
</p>

<?php $this->endWidget(); ?>