<?php
$this->breadcrumbs=array(
	'Product Sets'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create ProductSet', 'url'=>array('create')),
);

?>

<h1>Manage Product Sets</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-set-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'set_id',
		'set_title',
		'set_text',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {products} {delete}',
			'buttons'=>array(
				'products'=>array(
					'label'=>'Products',
					'url'=>'array("products","id"=>$data->set_id)',
					'imageUrl'=>'/shop/images/plus.png',
					'options'=>array(
						'class'=>'products',
					),
				),
			),
		),
	),
)); ?>

<?php $this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'.products',
));?>