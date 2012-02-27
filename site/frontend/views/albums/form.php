<div class="form">
<h2><?php echo $model->isNewRecord ? 'Создание' : 'Изменение' ?> альбома</h2>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'album-form',
    'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title', array('maxlength' => 100)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description', array('maxlength' => 255)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>