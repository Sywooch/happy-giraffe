<?php
$this->breadcrumbs=array(
	'Возрасты'=>array('admin'),
	'Администрирование',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('age-range-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Администрирование</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.RGridView.RGridViewWidget', array(
	'id'=>'age-range-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'rowCssId'=>'$data->range_id',
	'buttonLabel'=>'Сохранить сортировку',
	'options'=>array(
		'cursor' => 'crosshair',
	),
	'columns'=>array(
		'range_id',
		'range_title',
//		'range_order',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>