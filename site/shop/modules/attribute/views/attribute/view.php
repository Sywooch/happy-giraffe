<?php
$this->breadcrumbs = array(
	'Product Attributes' => array('index'),
	$model->attribute_id,
);

$this->menu = array(
	array('label' => 'Create ProductAttribute', 'url' => array('create')),
	array('label' => 'Update ProductAttribute', 'url' => array('update', 'id' => $model->attribute_id)),
	array('label' => 'Delete ProductAttribute', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->attribute_id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Manage ProductAttribute', 'url' => array('admin')),
);
?>

<h1>View ProductAttribute #<?php echo $model->attribute_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'attribute_id',
		'attribute_title',
		'attribute_text',
		'type',
		'attribute_required',
		'attribute_is_insearch',
	),
));
?>

<?php
//string
if($model->attribute_type == 1):
	?>
<h3>Possible values</h3>
	<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'product-attribute-value-grid',
		'dataProvider' => $attribytes,
		'columns' => array(
			'value_value',
			array(
				'class' => 'CButtonColumn',
				'template' => '{vupdate} {vdelete}',
				'buttons'=>array(
					'vupdate'=>array(
						'label'=>'Update values',
						'imageUrl'=>'/shop/images/update.png',
						'url'=>'array("/attribute/attributeValueMap/update","id"=>$data["map_id"],"vid"=>$data["value_id"])',
						'options'=>array(
							'class'=>'vupdate',
						),
					),
					'vdelete'=>array(
						'label'=>'Dalete values',
						'imageUrl'=>'/shop/images/delete.png',
						'url'=>'array("/attribute/attributeValueMap/delete","id"=>$data["map_id"],"vid"=>$data["value_id"])',
						'click'=>'function(){if(!confirm("Are you shure want delete this item?")){return false;}}',
					),
				),
			),
		),
	));
	?>
	<?php echo CHtml::link('Add possible value', array('/attribute/attributeValueMap/create','id'=>$model->attribute_id), array(
		'id'=>'addValue'
	)); ?>
<?php endif; ?>

<?php
$this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'#addValue, .vupdate',
));
?>