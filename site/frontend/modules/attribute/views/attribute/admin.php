<?php
$this->breadcrumbs=array(
	'Product Attributes'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create ProductAttribute', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-attribute-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Attributes</h1>

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
	'id'=>'product-attribute-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'attribute_id',
		'attribute_title',
		'attribute_text',
		array(
			'name'=>'type',
			'filter'=>$model->types->statuses,
		),
		'attribute_required',
		'attribute_is_insearch',
        'price_influence',
		array(
			'class'=>'CButtonColumn',
//			'template'=>'{view} {values} {update} {delete}',
//			'buttons'=>array(
//				'values'=>array(
//					'label'=>'Set values',
//					'imageUrl'=>'/shop/images/plus.png',
//					'url'=>'array("/attribute/attributeValueMap/create","id"=>$data->attribute_id)',
//					'visible'=>'$data->attribute_type==1',//string
//				),
//			),
		),
	),
)); ?>
