<?php
$this->breadcrumbs = array(
	'Categories' => array('index'),
	$model->category_name => array('view', 'id' => $model->category_id),
	'Update',
);

$this->menu = array(
	array('label' => 'List Category', 'url' => array('index')),
	array('label' => 'Create Category', 'url' => array('create')),
	array('label' => 'View Category', 'url' => array('view', 'id' => $model->category_id)),
	array('label' => 'Manage Category', 'url' => array('admin')),
);
?>

<h1>Attributes for Category <?php echo $model->category_name; ?></h1>

<div class="form">
	<?php echo CHtml::beginForm(); ?>

	<div class="row">
		<label>Select attribute set</label>
		<?php echo CHtml::hiddenField('attribute_id', 0, array('id' => 'attribute_id')); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name' => 'attribute_title',
			'source' => $this->createUrl('attributeList'),
			// additional javascript options for the autocomplete plugin
			'options' => array(
				'minLength' => '0',
				'select' => 'js:function( event, ui ) {
					$( "#attribute_id" ).val( ui.item.attribute_id );
					$(this).val( ui.item.attribute_title );
					return false;
				}',
			),
			'htmlOptions' => array(
				'size' => 60,
				'maxlength' => 250,
			),
		));
		
		$js = '$("#attribute_title").data("autocomplete")._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>"
					+ item.attribute_title
					+ "<br/><span class=\"small\" style=\"font-style:italic;\">"
					+ item.attribute_text + "</span></a>" )
				.appendTo( ul );
		}';
		Yii::app()->clientScript->registerScript('cuAutocomplete', $js);
		
		?>
		<?php
		echo CHtml::link('All', '#', array(
			'id'=>'all_attributes',
			'onclick' => '$("#attribute_title").autocomplete( "search" , ""); return false;',
		));
		?>
	</div>

	<div class="row buttons">
	<?php echo CHtml::submitButton('Add attribute'); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div>