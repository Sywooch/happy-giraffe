<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model VaccineDate
 */
?>
<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <label for="Vaccine">Вакцина</label><?php
    $this->widget('application.components.Relation', array(
            'model' => $model,
            'relation' => 'vaccine',
            'fields' => 'name',
            'allowEmpty' => false,
            'style' => 'dropdownlist',
        )
    ); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'time_from'); ?>
    <?php echo $form->textField($model, 'time_from', array('size' => 4, 'maxlength' => 4)); ?>
    <?php echo $form->error($model, 'time_from'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'time_to'); ?>
    <?php echo $form->textField($model, 'time_to', array('size' => 4, 'maxlength' => 4)); ?>
    <?php echo $form->error($model, 'time_to'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'adult'); ?>
    <?php echo $form->checkBox($model, 'adult'); ?>
    <?php echo $form->error($model, 'adult'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'interval'); ?>
    <?php echo $form->dropDownList($model, 'interval', array('1'=>'часов','2'=>'дней','3'=>'месяцев','4'=>'лет')); ?>
    <?php echo $form->error($model, 'interval'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'every_period'); ?>
    <?php echo $form->textField($model, 'every_period'); ?>
    <?php echo $form->error($model, 'every_period'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'age_text'); ?>
    <?php echo $form->textField($model, 'age_text', array('size' => 60, 'maxlength' => 256)); ?>
    <?php echo $form->error($model, 'age_text'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'vaccination_type'); ?>
    <?php echo $form->dropDownList($model, 'vaccination_type',$model->vaccine_type_names); ?>
    <?php echo $form->error($model, 'vaccination_type'); ?>
</div>
<br>
<br>
<label for="VaccineDisease">Болезни</label><?php
$this->widget('application.components.Relation', array(
        'model' => $model,
        'relation' => 'diseases',
        'fields' => 'name',
        'allowEmpty' => false,
        'style' => 'checkbox',
    )
); ?>
			