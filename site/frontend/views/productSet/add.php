<div class="form wide">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'product-set-map-add-form',
		'enableAjaxValidation' => true,
		));
	?>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->hiddenField($model, 'map_set_id'); ?>

    <div class="row">
		<?php echo $form->labelEx($model, 'map_product_id'); ?>
		<?php
		echo $form->hiddenField($model, 'map_product_id',array(
			'id'=>'map_product_id',
		));
//		echo $form->textField($model, 'map_product_id');
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name' => 'product',
			'source' => $this->createUrl('psearch'),
			// additional javascript options for the autocomplete plugin
			'options' => array(
				'minLength' => '2',
				'select' => 'js: function(event, ui) {
						this.value = ui.item.label;
						$("#map_product_id").val(ui.item.id);
						return false;
					}',
			),
			'htmlOptions' => array(
				'id' => 'product',
				'size'=>50,
			),
		));

		$js = '$("#product").data("autocomplete")._renderItem = function( ul, item ) {
				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<img src=\'" + item.img + "\' alt=\'" + item.label + "\' align=\'left\'/><a><b>" + item.label + "</b></a>" )
					.appendTo( ul );
			}';
		Yii::app()->clientScript->registerScript('prAutocomplete', $js);
		?>
		<?php echo $form->error($model, 'map_product_id'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'map_product_count'); ?>
		<?php echo $form->textField($model,'map_product_count',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'map_product_count'); ?>
	</div>

    <div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
    </div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
