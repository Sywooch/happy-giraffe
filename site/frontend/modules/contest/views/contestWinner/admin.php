<?php
$this->breadcrumbs=array(
	'Contest Winners'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ContestWinner', 'url'=>array('index')),
	array('label'=>'Create ContestWinner', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('contest-winner-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Contest Winners</h1>

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
	'id'=>'contest-winner-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'winner_id',
		'winner_contest_id',
		'winner_place',
		'winner_prize_id',
		'winner_user_id',
		'winner_work_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
