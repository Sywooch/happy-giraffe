<?php
/* @var $this Controller
 * @var $form CActiveForm
 */

$model->image_id = '1';
$model->title = '1';

?><?php echo CHtml::link('К таблице', array('Line/admin')) ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'line-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
        <?php echo $form->error($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', Line::model()->text_types); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'image_id'); ?>
        <?php echo $form->textField($model, 'image_id'); ?>
        <?php echo $form->error($model, 'image_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'model' => $model,
        'attribute' => 'date',
        'language' => 'ru',
        'options' => array(
            'showAnim' => 'fold',
            'dateFormat' => 'yy-mm-dd',
        ),
        'htmlOptions' => array(
            'style' => 'height:20px;'
        ),
    )); ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>

    <div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?php
        if ($model->isNewRecord) {
            echo CHtml::submitButton('Создать', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        } else {
            echo CHtml::submitButton('Сохранить');
            echo CHtml::submitButton('Сохранить и продолжить', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        }
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->