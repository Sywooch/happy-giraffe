 <?php echo CHtml::link('К таблице', array('Route/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'route-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'city_from_id'); ?>
		<?php echo $form->textField($model,'city_from_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'city_from_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_to_id'); ?>
		<?php echo $form->textField($model,'city_to_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'city_to_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wordstat_value'); ?>
		<?php echo $form->textField($model,'wordstat_value'); ?>
		<?php echo $form->error($model,'wordstat_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'distance'); ?>
		<?php echo $form->textField($model,'distance'); ?>
		<?php echo $form->error($model,'distance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_from_out_links_count'); ?>
		<?php echo $form->textField($model,'city_from_out_links_count'); ?>
		<?php echo $form->error($model,'city_from_out_links_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_to_out_links_count'); ?>
		<?php echo $form->textField($model,'city_to_out_links_count'); ?>
		<?php echo $form->error($model,'city_to_out_links_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checked'); ?>
		<?php echo $form->textField($model,'checked'); ?>
		<?php echo $form->error($model,'checked'); ?>
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

</div><!-- form -->