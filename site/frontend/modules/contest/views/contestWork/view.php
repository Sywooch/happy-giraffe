<?php
$this->breadcrumbs=array(
	'Contest Works'=>array('index'),
	$model->work_title,
);

$this->menu=array(
	array('label'=>'List ContestWork', 'url'=>array('index')),
	array('label'=>'Create ContestWork', 'url'=>array('create')),
	array('label'=>'Update ContestWork', 'url'=>array('update', 'id'=>$model->work_id)),
	array('label'=>'Delete ContestWork', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->work_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContestWork', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->work_title; ?></h1>

<?php
/**
 * @todo link for All user's works
 */

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'work_id',
		array(
			'label'=>'work_user_id',
			'value'=>CHtml::link("All user's works", array('#')),
			'type'=>'raw',
		),
		array(
			'label'=>'work_contest_id',
			'value'=>CHtml::link($model->contest->contest_title, $model->contest->url),
			'type'=>'raw',
		),
		array(
			'name'=>'work_image',
			'value'=>$model->getImageUrl('big'),
			'type'=>'image',
		),
		'work_text',
		'work_time:datetime',
		'work_rate',
//		'work_status',
	),
)); ?>


<h1>Contest Work Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$commentDataProvider,
	'itemView'=>'/contestWorkComment/_view',
)); ?>


<?php echo CHtml::link('Add Comment', array(
	'/contest/contestWorkComment/create',
	'id'=>$model->work_id,
), array(
	'id'=>'addComment',
)); ?>




<?php
$this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'#addComment',
));
?>