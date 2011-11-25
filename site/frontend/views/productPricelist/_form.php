<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-pricelist-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pricelist_title'); ?>
		<?php echo $form->textField($model,'pricelist_title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'pricelist_title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'pricelist_title'); ?>
		<?php
		
$this->widget('ext.html5uploader.damnUploaderWidget',array(
	'name'=>'test',
//	'text'=>'Drop file here',
	'url'=>array('file'),
	'options'=>array(
//		'onComplete'=>'js:function(successfully, data, errorCode){
//			if(successfully)
//			{
//				alert(data);
//			}
//			else
//			{
//				alert(errorCode);
//			}
//		}',
		'onSelect'=>'js:function(file) {
			addFileToQueue(file);
			return false;
		},
        }',
		'multiple'=>true,
	),
	'htmlOptions'=>array(
		'style'=>'width: 99%;border: 1px dotted #999;'
	)
));
		
		?>
		<?php echo $form->error($model,'pricelist_title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->