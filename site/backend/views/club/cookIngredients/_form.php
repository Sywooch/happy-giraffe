<?php echo CHtml::link('К таблице', array('club/CookIngredients/admin')) ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-ingredients-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php
        echo $form->labelEx($model, 'category_id');
        echo $form->dropDownList($model, 'category_id', CookIngredientsCategories::getCategories());
        echo $form->error($model, 'category_id');
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'unit_id'); ?>
        <?php echo $form->dropDownList($model, 'unit_id', CookUnits::getUnits()); ?>
        <?php echo $form->error($model, 'unit_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'weight'); ?>
        <?php echo $form->textField($model, 'weight', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'weight'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'density'); ?>
        <?php echo $form->textField($model, 'density', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'density'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

    <?php
    if (!$model->isNewRecord) {
        $this->renderPartial('_form_nutritionals', array('model' => $model));
    }
    ?>

</div><!-- form -->