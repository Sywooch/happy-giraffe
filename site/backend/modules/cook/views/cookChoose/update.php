<h1>Обновление записи № <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php echo CHtml::link('К таблице', array('admin')) ?>

<div class="form">


    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-choose-form',
    'enableAjaxValidation' => false,
)); ?>


    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'category_id'); ?>
        <?php
        echo $form->dropDownList($model, 'category_id',
            CHtml::listData(CookChooseCategory::model()->findAll(), 'id', 'title')
        );
        ?>
        <?php echo $form->error($model, 'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title_accusative'); ?>
        <?php echo $form->textField($model, 'title_accusative', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title_accusative'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'desc'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'desc')); ?>
        <?php echo $form->error($model, 'desc'); ?>
    </div>

    <div class="row">
        trololo
        <?php echo $form->labelEx($model, 'title_quality'); ?>
        <?php echo $form->textField($model, 'title_quality', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'качественный продукт')); ?>
        <?php echo $form->error($model, 'title_quality'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'desc_quality'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'desc_quality')); ?>
        <?php echo $form->error($model, 'desc_quality'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title_defective'); ?>
        <?php echo $form->textField($model, 'title_defective', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'некачественный продукт')); ?>
        <?php echo $form->error($model, 'title_defective'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'desc_defective'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'desc_defective')); ?>
        <?php echo $form->error($model, 'desc_defective'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title_check'); ?>
        <?php echo $form->textField($model, 'title_check', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'качество продукта')); ?>
        <?php echo $form->error($model, 'title_check'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'desc_check'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'desc_check')); ?>
        <?php echo $form->error($model, 'desc_check'); ?>
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