<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 30)); ?>
    <?php echo $form->error($model, 'name'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'gender'); ?>
    <?php echo $form->dropDownList($model, 'gender', array('1' => 'муж', '2' => 'жен')); ?>
    <?php echo $form->error($model, 'gender'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'translate'); ?>
    <?php echo $form->textField($model, 'translate', array('size' => 60, 'maxlength' => 512)); ?>
    <?php echo $form->error($model, 'translate'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'origin'); ?>
    <?php echo $form->textField($model, 'origin', array('size' => 60, 'maxlength' => 2048)); ?>
    <?php echo $form->error($model, 'origin'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'options'); ?>
    <?php echo $form->textField($model, 'options', array('size' => 60, 'maxlength' => 512)); ?>
    <?php echo $form->error($model, 'options'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'sweet'); ?>
    <?php echo $form->textField($model, 'sweet', array('size' => 60, 'maxlength' => 512)); ?>
    <?php echo $form->error($model, 'sweet'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'middle_names'); ?>
    <?php echo $form->textField($model, 'middle_names', array('size' => 60, 'maxlength' => 1024)); ?>
    <?php echo $form->error($model, 'middle_names'); ?>
</div>

<label for="NameGroup">Группа</label><?php
$this->widget('application.components.Relation', array(
        'model' => $model,
        'relation' => 'nameGroup',
        'fields' => 'name',
        'allowEmpty' => false,
        'style' => 'dropdownlist',
    )
); ?>
