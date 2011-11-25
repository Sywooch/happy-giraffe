<h1>Manage Products</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-set-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'header'=>'Image',
			'value'=>'$data["product_image"]->getUrl("thumb")',
			'type'=>'image',
		),
		array(
			'header'=>'Title',
			'value'=>'$data["product_title"]',
		),
		'map_product_count',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{del}',
			'buttons'=>array(
				'del'=>array(
					'label'=>'Remove',
					'url'=>'array("sub")',
					'url'=>'array("sub","id"=>$data["id"])',
					'imageUrl'=>'/shop/images/delete.png',
					'click'=>'function(){return confirm("Are you shure?");}',
				),
			),
		),
	),
)); ?>
