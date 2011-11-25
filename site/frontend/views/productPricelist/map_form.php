<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'product-set-form',
		'enableAjaxValidation'=>true,
	)); ?>

	<?php echo CHtml::activeHiddenField($map, 'map_pricelist_id'); ?>
	<?php echo CHtml::activeHiddenField($map, 'map_id', array('id'=>'map_id')); ?>

	<div class="row">
		<?php echo $form->labelEx($map,'map_product_id'); ?>
		<?php echo $form->hiddenField($map, 'map_product_id',array('id'=>'map_set_id_h')); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'map_set_id',
			'source'=>$this->createUrl('ajaxSets',array('id'=>$model->pricelist_id)),
			'options'=>array(
				'minLength'=>'0',
				'select'=>'js:function( event, ui ) {
						$( "#map_set_id_h" ).val( ui.item.id );
						$(this).val( ui.item.value );
						return false;
					}',
			),
			'htmlOptions'=>array(
				'size'=>60,
				'maxlength'=>250,
				'value'=>$map->getIsNewRecord()?'':$map->product->product_title,
			),
		));?>
		<?php echo CHtml::link('All', '#', array(
			'onclick'=>'$("#map_set_id").autocomplete( "search" , ""); return false;',
		)); ?>
		<?php echo $form->error($map,'map_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($map,'map_set_price'); ?>
		<?php echo $form->textField($map,'map_set_price',array('size'=>60,'maxlength'=>250, 'id'=>'map_set_price')); ?>
		<?php echo $form->error($map,'map_set_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Add'); ?>
	</div>

	<?php $this->endWidget(); ?>
</div>