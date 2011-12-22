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
    <?php echo $form->labelEx($model, 'middle_name'); ?>
    <?php echo $form->textField($model, 'middle_name', array('size' => 50, 'maxlength' => 50)); ?>
    <?php echo $form->error($model, 'middle_name'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'last_name'); ?>
    <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
    <?php echo $form->error($model, 'last_name'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 256)); ?>
    <?php echo $form->error($model, 'description'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'photo'); ?>
    <?php echo $form->textField($model, 'photo', array('size' => 60, 'maxlength' => 256)); ?>
    <?php echo $form->error($model, 'photo'); ?>
</div>
