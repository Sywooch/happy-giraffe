<?php
$this->breadcrumbs = array(
	'Категории' => array('admin'),
	$model->category_name => array('view', 'id' => $model->category_id),
	'Набор атрибутов',
);

$this->menu = array(
	array('label' => 'Показать', 'url' => array('view', 'id' => $model->category_id)),
	array('label' => 'Администрирование', 'url' => array('admin')),
);
?>

<h1>Набор атрибутов для <?php echo $model->category_name; ?></h1>

<div class="form">
	<?php echo CHtml::beginForm(); ?>

	<div class="row">
		<label>Select attribute set</label>
		<?php echo CHtml::hiddenField('set_id', 0, array('id' => 'set_id')); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name' => 'set_title',
			'source' => $this->createUrl('attributeListSet'),
			// additional javascript options for the autocomplete plugin
			'options' => array(
				'minLength' => '0',
				'select' => 'js:function( event, ui ) {
					$( "#set_id" ).val( ui.item.set_id );
					$(this).val( ui.item.set_title );
					return false;
				}',
			),
			'htmlOptions' => array(
				'size' => 60,
				'maxlength' => 250,
			),
		));
		
		$js = '$("#set_title").data("autocomplete")._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.set_title + "<br/><span class=\"small\" style=\"font-style:italic;\">" + item.set_text + "</span></a>" )
				.appendTo( ul );
		}';
		Yii::app()->clientScript->registerScript('cuAutocomplete', $js);
		
		?>
		<?php
		echo CHtml::link('Все', '#', array(
			'id'=>'all_attributes_set',
			'onclick' => '$("#set_title").autocomplete( "search" , ""); return false;',
		));
		?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton('Добавить'); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div>