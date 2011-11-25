<?php
$this->breadcrumbs=array(
	'Продукты'=>array('admin'),
	$model->product_title,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->product_id)),
	array('label'=>'Видео', 'url'=>array('admin/productVideo/create', 'id'=>$model->product_id)),
//	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->product_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Администрирование', 'url'=>array('admin')),
	array('label'=>'Дополнительные изображения', 'url'=>array('/admin/productImage/admin','id'=>$model->product_id)),
);
?>

<h1><?php echo $model->product_title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'product_id',
		'product_articul',
		array(
			'name'=>'product_image',
			'value'=>$model->product_image->getUrl("subproduct"),
			'type'=>'image',
		),
//		'product_type',
		'product_title',
		'product_buy_price',
		'product_sell_price',
		'product_price',
		'product_text',
		'product_keywords',
		'product_description',
		'product_time:datetime',
		array(
			'name'=>'product_status',
			'value'=>$model->statusText,
		),
//		'product_rate',
//		'imageCount',
//		'subProductCount',
//		'product_attribute_set_id',
	),
)); ?>

<h3>Изображения</h3>

<?php echo CHtml::link('Изображения', array('/admin/productImage/admin','id'=>$model->product_id)); ?>

<?php $this->widget('ext.imageGridView.imageGridView', array(
	'id'=>'product-image-grid',
	'dataProvider'=>$images->search($criteriaImage),
	'filter'=>$images,
	'width'=>90,
	'height'=>120,
	'columns'=>array(
//		'image_id',
//		'image_product_id',
//		'image_file',
		array(
			'name'=>'product_image',
			'value'=>'$data->image_file->getUrl("product_thumb")',
			'type'=>'image',
			'filter'=>false,
		),
//		'image_time',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
			'viewButtonUrl'=>'array("/admin/productImage/view","id"=>$data->image_id)',
			'deleteButtonUrl'=>'array("/admin/productImage/delete","id"=>$data->image_id)',
		),
	),
)); ?>

<h3>Атрибуты</h3>

<?php echo CHtml::link('Редактировать атрибуты', array('attributes','id'=>$model->product_id), array(
	'id'=>'attributes',
)); ?>

<?php foreach ($model->getAttributesText() as $attribute): ?>
<p><?php echo $attribute['attribute_title'];?> - <?php echo $attribute['eav_attribute_value'];?></p>
<?php endforeach; ?>

<h3>Зависимые продукты</h3>

<?php echo CHtml::link('Зависимые продукты', array('/admin/product/addSubProduct', 'id'=>$model->product_id,), array(
	'class'=>'subProduct',
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$subProducts->search($criteriaSubProduct),
	'filter'=>$subProducts,
	'columns'=>array(
//		'product_id',
//		'product_image',
		array(
			'name'=>'product_image',
			'value'=>'$data->product_image->getUrl("subproduct")',
			'type'=>'image',
			'filter'=>false,
		),
//		array(
//			'name'=>'product_type',
//			'filter'=>ProductType::model()->listAll(),
//		),
		'product_title',
		'product_text',
		/*
		'product_keywords',
		'product_description',
		'product_time',
		'product_rate',
//		'product_attribute_set_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
			'viewButtonUrl'=>'array("view","id"=>$data->product_id)',
			'deleteButtonUrl'=>'array("subDelete","id"=>$data->product_id,"mid"=>'.$model->product_id.')',
		),
	),
)); ?>



<?php
$this->widget('ext.fancybox.EFancyBox', array(
	'target'=>'#attributes, .subProduct',
));
; ?>