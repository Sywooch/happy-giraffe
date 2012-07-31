<h1>Редактирование периода «<?=$model->title?>» в календаре ребёнка</h1>

<?php echo CHtml::link('К таблице', array('admin')) ?>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'cook-unit-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'heading'); ?>
        <?php echo $form->textField($model,'heading',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'heading'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'slug'); ?>
        <?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'slug'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'text')); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'features_heading'); ?>
        <?php echo $form->textField($model,'features_heading',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'features_heading'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'features'); ?>
        <?php echo $form->textArea($model, 'features', array('cols' => 60, 'rows' => 6)); ?>
        <?php echo $form->error($model,'features'); ?>
    </div>

    <hr />

    <div class="row">
        <?php echo $form->labelEx($model,'contents'); ?>
        <?php echo $form->textArea($model, 'contentsText', array('cols' => 60, 'rows' => 6)); ?>
        <?php echo $form->error($model,'contents'); ?>
    </div>

    <hr />

    <div class="row">
        <?php echo $form->labelEx($model,'services'); ?>

        <?php echo $form->checkBoxList($model, 'servicesIds', CHtml::listData(Service::model()->findAll(), 'id', 'title'), array('labelOptions' => array('style' => 'display: inline-block;'))); ?>
    </div>

    <hr />

    <div class="row">
        <?php echo $form->labelEx($model,'communities'); ?>

        <?php echo $form->checkBoxList($model, 'communitiesIds', CHtml::listData(Community::model()->findAll(array('condition' => 'id < 19')), 'id', 'title'), array('labelOptions' => array('style' => 'display: inline-block;'))); ?>
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
</div>