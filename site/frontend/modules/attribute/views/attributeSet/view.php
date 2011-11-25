<?php
$this->breadcrumbs = array(
	'Product Attribute Sets' => array('admin'),
	$model->set_title,
);

$this->menu = array(
	array('label' => 'Create ProductAttributeSet', 'url' => array('create')),
	array('label' => 'Update ProductAttributeSet', 'url' => array('update', 'id' => $model->set_id)),
	array('label' => 'Delete ProductAttributeSet', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->set_id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Manage ProductAttributeSet', 'url' => array('admin')),
);
?>

<h1>View ProductAttributeSet #<?php echo $model->set_title; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'set_id',
		'set_title',
		'set_text',
	),
));
?>

<h3>Items</h3>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'product-attribute-value-grid',
	'dataProvider' => $attribytes,
	'columns' => array(
		'map_attribute_title',
		'attribute_title',
		array(
			'class' => 'CButtonColumn',
			'template' => '{vupdate} {vdelete}',
			'buttons' => array(
				'vupdate' => array(
					'label' => 'Update values',
					'imageUrl' => '/shop/images/update.png',
					'url' => 'array("/attribute/attributeSetMap/update","id"=>$data["id"])',
					'options' => array(
						'class' => 'vupdate',
					),
				),
				'vdelete' => array(
					'label' => 'Dalete values',
					'imageUrl' => '/shop/images/delete.png',
					'url' => 'array("/attribute/attributeSetMap/delete","id"=>$data["id"])',
					'click' => 'function(){if(!confirm("Are you shure want delete this item?")){return false;}}',
				),
			),
		),
	),
));
?>
<?php
echo CHtml::link('Add item', array('/attribute/attributeSetMap/create', 'id' => $model->set_id), array(
	'id' => 'addItem'
));
?>

<?php
$this->widget('ext.fancybox.EFancyBox', array(
	'target' => '#addItem, .vupdate',
));
?>