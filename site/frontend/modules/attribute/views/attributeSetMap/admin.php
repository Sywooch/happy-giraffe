<?php
$this->breadcrumbs=array(
	'Product Attribute Set Maps'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProductAttributeSetMap', 'url'=>array('index')),
	array('label'=>'Create ProductAttributeSetMap', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-attribute-set-map-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Attribute Set Maps</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-attribute-set-map-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'map_id',
		'map_set.set_title',
		'map_attribute.attribute_title',
		'map_attribute_title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
