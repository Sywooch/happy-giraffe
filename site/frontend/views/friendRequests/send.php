<h1>Пригласить в друзья</h1>

<?php $form = $this->beginWidget('CActiveForm'); ?>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->labelEx($model,'text'); ?>
    <?php echo $form->textArea($model, 'text'); ?>

    <?php echo CHtml::submitButton('Отправить'); ?>
<?php $this->endWidget(); ?>