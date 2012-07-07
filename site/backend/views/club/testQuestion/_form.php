<?php echo CHtml::link('К таблице', array('club/TestQuestion/admin')) ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'test-question-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'test_id'); ?>
        <?php echo $form->textField($model, 'test_id'); ?>
        <?php echo $form->error($model, 'test_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'image'); ?>
        <?php echo $form->textField($model, 'image', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'number'); ?>
        <?php echo $form->textField($model, 'number'); ?>
        <?php echo $form->error($model, 'number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textArea($model, 'text', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<?php

if (!$model->isNewRecord) {

    $this->widget('zii.widgets.grid.CGridView', array(
        'enablePagination' => false,
        'summaryText' => '',
        'dataProvider' => new CActiveDataProvider ('TestQuestionAnswer', array(
            'criteria' => array(
                'condition' => 'test_question_id = ' . $model->id,
                'order' => 'id'
            ),
            'pagination' => array(
                'pageSize' => 100
            )
        )),
        'columns' => array(
            'id',
            array(
                'name' => 'text',
                'value' => 'CHtml::link ( CHtml::encode ( $data->text ),  array ( "club/TestQuestionAnswer/update", "id" => $data->id ) )',
                'type' => 'raw'
            ),

        ),
        'enablePagination' => false,
        'ajaxUpdate' => 'false'
    ));

}
?>