<?php
$breadcrumbs=array();
foreach($parents as $id=>$name)
{
	$breadcrumbs[$name] = array('view','id'=>$id);
}
$breadcrumbs[] = $model->category_name;

$this->breadcrumbs=$breadcrumbs;

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Main Category', 'url'=>array('root')),
	array('label'=>'Create SubCategory', 'url'=>array('create', 'id'=>$model->category_id)),
	
	array('label'=>'Create SubCategory', 'url'=>array('create', 'id'=>$model->category_id)),
	array('label'=>'Add attributes', 'url'=>array('connectAttributes', 'id'=>$model->category_id)),
	
	array('label'=>'Update Category', 'url'=>array('update', 'id'=>$model->category_id)),
	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->category_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<?php if(!Y::isAjaxRequest()): ?>
<h1><?php echo $model->category_title; ?></h1>

<div class="form wide">
	<?php
	$this->widget('FilterWidget', array(
		'category_id' => $model->category_id,
		'descendants' => $descendants,
	));
	?>
</div>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'category_id',
//		'category_lft',
//		'category_rgt',
//		'category_level',
		'category_name',
		'category_title',
		'category_text',
		'category_keywords',
		'category_description',
	),
)); ?>

<h3>Connected Attributes</h3>

<?php

$this->renderPartial('attributes',array(
	'model'=>$attrs,
	'criteria'=>$criteria,
	'category'=>$model,
))
?>

<?php echo CHtml::link('Add attributes set',array('connectAttributesSet','id'=>$model->category_id),array(
	'id'=>'add_attributes_set',
));?>
<br/>
<?php echo CHtml::link('Add attributes',array('connectAttributes','id'=>$model->category_id),array(
	'id'=>'add_attributes',
));?>

<?php
$this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'#add_attributes_set, #add_attributes',
));
?>
<?php endif; ?>

<div id="categoryContent">

<?php $this->widget('ext.RSortDropDownListWidget.RSortDropDownListWidget', array(
	'sort'=>$sort,
	'labels'=>array(
		'product_price'=>array(
			'asc'=>'По возврастанию цены',
			'deck'=>'По убыванию цены',
		),
		'product_time'=>array(
			'asc'=>'Старые вперед',
			'deck'=>'Новые вперед',
		),
//		'product_rate'=>array(
//			'asc'=>'По возврастанию цены',
//			'deck'=>'По убыванию цены',
//		),
		'product_title'=>array(
			'asc'=>'По алфавиту',
			'deck'=>'По алфавиту (инверсия)',
		),
	),
));?>
	
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$products,
//	'filter'=>$model,
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
		'product_price',
		'product_sell_price',
		/*
		'product_keywords',
		'product_description',
		'product_time',
		'product_rate',
		'product_attribute_set_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'viewButtonUrl'=>'array("product/view","id"=>$data->product_id)',
		),
	),
)); ?>

</div>