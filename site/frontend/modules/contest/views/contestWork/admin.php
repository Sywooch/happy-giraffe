<?php
$this->breadcrumbs=array(
	'Contest Works'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ContestWork', 'url'=>array('index')),
	array('label'=>'Create ContestWork', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('contest-work-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Contest Works</h1>

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
	'id'=>'contest-work-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'work_id',
		'work_user_id',
		'work_contest_id',
		'work_title',
		'work_text',
		'work_image',
		/*
		'work_time',
		'work_rate',
		'work_status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
