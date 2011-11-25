<?php
$breadcrumbs=array();
foreach($parents as $id=>$name)
{
	$breadcrumbs[$name] = array('view','id'=>$id);
}
$breadcrumbs[] = $model->category_name;

$this->breadcrumbs=$breadcrumbs;

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('root')),
	array('label'=>'Создать подкатегорию', 'url'=>array('create', 'id'=>$model->category_id)),
	
	array('label'=>'Добавить атрибуты', 'url'=>array('connectAttributes', 'id'=>$model->category_id)),
	
	array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->category_id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->category_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Администрирование', 'url'=>array('admin')),
);
?>

<?php if(!Y::isAjaxRequest()): ?>
<h1><?php echo $model->category_title; ?></h1>

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

<h3>Атрибуты</h3>

<?php echo CHtml::link('Добавить набор атрибутов',array('connectAttributesSet','id'=>$model->category_id),array(
	'id'=>'add_attributes_set',
));?>
<br/>
<?php echo CHtml::link('Добавить атрибут',array('connectAttributes','id'=>$model->category_id),array(
	'id'=>'add_attributes',
));?>

<?php
$this->renderPartial('attributes',array(
	'model'=>$attrs,
	'criteria'=>$criteria,
	'category'=>$model,
))
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
			'value'=>'$data->product_image->getUrl("product_thumb")',
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

<?php if(!Y::isAjaxRequest()): ?>
<?php
$this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'#add_attributes_set, #add_attributes',
));
?>
<?php endif; ?>