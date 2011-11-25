<?php
$this->breadcrumbs=array(
	'Product Pricelists'=>array('admin'),
	$model->pricelist_title,
	'Settings',
);

$this->menu=array(
	array('label'=>'Create ProductPricelist', 'url'=>array('create')),
	array('label'=>'Manage ProductPricelist', 'url'=>array('admin')),
);
?>

<h1>Settings Product Pricelist "<?php echo $model->pricelist_title; ?>"</h1>

<?php
echo CHtml::link('Add set', '#', array(
   'onclick'=>'$("#addset").dialog("open"); return false;',
));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-set-grid',
	'dataProvider'=>$products->search($criteria),
	'filter'=>$products,
	'columns'=>array(
		'product_id',
		array(
			'name'=>'product_image',
			'value'=>'$data->product_image->getUrl("thumb")',
			'type'=>'image',
			'filter'=>false,
		),
		array(
			'name'=>'product_title',
			'value'=>'CHtml::link($data->product_title, array("product/update","id"=>$data->product_id))',
			'type'=>'raw',
		),
		array(
			'name'=>'price',
			'value'=>'$data->getPrice('.$model->pricelist_id.')',
			'filter'=>false,
		),
		'product_text',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{products} {delete}',
			'deleteButtonUrl'=>'array("mapDelete","sid"=>$data->product_id,"pid"=>'.$model->pricelist_id.')',
			'buttons'=>array(
				'products'=>array(
					'label'=>'Products',
					'url'=>'array("products","id"=>$data->product_id,"pid"=>'.$model->pricelist_id.')',
					'imageUrl'=>'/shop/images/plus.png',
					'options'=>array(
						'class'=>'products',
					),
				),
			),
		),
	),
)); ?>

<?php 
$js = '$(".products").live("click",function(){
	'.CHtml::ajax(array(
		'url'=>'js:$(this).attr("href")',
		'dataType'=>'json',
		'success'=>'js:function(data){
			$( "#map_set_id_h" ).val( data.map_product_id );
			$("#map_set_id").val( data.product_title );
			$("#map_set_price").val( data.map_set_price );
			$("#map_id").val( data.map_id );
			$("#addset").dialog("open");
			return false;
		}',
	)).'
	return false;
})';

Y::script()->registerScript('products', $js);
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'addset',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Add set',
        'autoOpen'=>$map->hasErrors(),
		'width'=>600,
    ),
));

echo $this->renderPartial('map_form', array(
	'map'=>$map,
	'model'=>$model,
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>