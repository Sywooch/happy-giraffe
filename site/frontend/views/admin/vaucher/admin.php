<?php
$this->breadcrumbs=array(
	'Vauchers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Vaucher', 'url'=>array('index')),
	array('label'=>'Create Vaucher', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vaucher-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vauchers</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vaucher-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'vaucher_id',
		'vaucher_code',
		'vaucher_discount',
//		'vaucher_time',
		'vaucher_from_time',
		'vaucher_till_time',
		/*
		'vaucher_text',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
