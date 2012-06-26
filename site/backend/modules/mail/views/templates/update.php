<h1>Update MailTemplate <?php echo $model->id; ?></h1>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'mail-template-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'subject'); ?>
        <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'subject'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'body'); ?>
        <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'body'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->