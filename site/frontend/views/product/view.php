<?php
$this->breadcrumbs=array(
	'Products'=>array('admin'),
	$model->product_title,
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->product_id)),
	array('label'=>'Delete Product', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->product_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
	array('label'=>'Manage Product Images', 'url'=>array('/productImage/admin','id'=>$model->product_id)),
);
?>

<h1><?php echo $model->product_title; ?></h1>

<?php echo CHtml::ajaxLink('Buy', array('shop/putIn', 'id'=>$model->product_id), array(
	'dataType'=>'json',
	'success'=>'js:function(msg){
		$("#ShoppingCard").html(msg.msg);
	}',
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'product_id',
		'product_articul',
		array(
			'name'=>'product_image',
			'value'=>$model->product_image->getUrl("midle"),
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

<h3>Attributes</h3>

<?php foreach ($model->getAttributesText() as $attribute): ?>
<p><?php echo $attribute['attribute_title'];?> - <?php echo $attribute['eav_attribute_value'];?></p>
<?php endforeach; ?>

<?php echo CHtml::link('Update attributes', array('attributes','id'=>$model->product_id), array(
	'id'=>'attributes',
)); ?>

<?php
$this->widget('ext.fancybox.EFancyBox', array(
	'target'=>'#attributes',
));
; ?>

<h3>Product Images</h3>

<?php $this->widget('ext.imageGridView.imageGridView', array(
	'id'=>'product-image-grid',
	'dataProvider'=>$images->search($criteriaImage),
	'filter'=>$images,
	'width'=>70,
	'height'=>100,
	'columns'=>array(
//		'image_id',
//		'image_product_id',
//		'image_file',
		array(
			'name'=>'product_image',
			'value'=>'$data->image_file->getUrl("thumb")',
			'type'=>'image',
			'filter'=>false,
		),
//		'image_time',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
			'viewButtonUrl'=>'array("productImage/view","id"=>$data->image_id)',
			'deleteButtonUrl'=>'array("productImage/delete","id"=>$data->image_id)',
		),
	),
)); ?>

<h3>Subproduct</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$subProducts->search($criteriaSubProduct),
	'filter'=>$subProducts,
	'columns'=>array(
//		'product_id',
//		'product_image',
		array(
			'name'=>'product_image',
			'value'=>'$data->product_image->getUrl("thumb")',
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