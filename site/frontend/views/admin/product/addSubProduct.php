<h1>Добавить зависимый продукт</h1>

<div class="form">

	<?php echo CHtml::beginForm(); ?>
	<?php echo CHtml::hiddenField('main_product_id', $model->product_id); ?>

	<div class="row">
		<label>Subproduct</label>
		<?php echo CHtml::hiddenField('product_id', 0, array('id' => 'product_id')); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name' => 'product_title',
			'source' => $this->createUrl('productList'),
			// additional javascript options for the autocomplete plugin
			'options' => array(
				'minLength' => '0',
				'select' => 'js:function( event, ui ) {
					$( "#product_id" ).val( ui.item.product_id );
					$(this).val( ui.item.product_title );
					return false;
				}',
			),
			'htmlOptions' => array(
				'size' => 60,
				'maxlength' => 250,
			),
		));
		
		
		$js = '$("#product_title").data("autocomplete")._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a><img src=\""
					+ item.image + "\" align=\"left\">"
					+ item.product_title + "<br/><span class=\"small\" style=\"font-style:italic;\">"
					+ item.product_description + "</span><div class=\"clear\">&nbsp;</div></a>" )
				.appendTo( ul );
		};';
		Yii::app()->clientScript->registerScript('cuAutocomplete', $js);
		
		?>
		<?php
		echo CHtml::link('All', '#', array(
			'onclick' => '$("#product_title").autocomplete( "search" , ""); return false;',
		));
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->