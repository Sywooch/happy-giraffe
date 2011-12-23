<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<label for="Name">Имя</label><?php
$this->widget('application.components.Relation', array(
        'model' => $model,
        'relation' => 'name',
        'fields' => 'name',
        'allowEmpty' => false,
        'style' => 'dropdownlist',
    )
); ?>

<div class="row">
    <?php echo $form->labelEx($model, 'day'); ?>
    <?php echo $form->textField($model, 'day', array('size' => 10, 'maxlength' => 10)); ?>
    <?php echo $form->error($model, 'day'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'month'); ?>
    <?php echo $form->textField($model, 'month', array('size' => 10, 'maxlength' => 10)); ?>
    <?php echo $form->error($model, 'month'); ?>
</div>

