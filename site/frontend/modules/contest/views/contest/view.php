<?php
$this->breadcrumbs=array(
	'Contests'=>array('index'),
	$model->contest_title,
);

$this->menu=array(
	array('label'=>'List Contest', 'url'=>array('index')),
	array('label'=>'Create Contest', 'url'=>array('create')),
	array('label'=>'Update Contest', 'url'=>array('update', 'id'=>$model->contest_id)),
	array('label'=>'Delete Contest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->contest_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Contest', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->contest_title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'contest_id',
//		'contest_title',
		'contest_text',
		array(
			'name'=>'contest_image',
			'value'=>$model->getImageUrl('thumb'),
			'type'=>'image',
		),
		'contest_from_time',
		'contest_till_time',
		array(
			'name'=>'contest_status',
			'value'=>$model->statuses->statusText,
		),
//		'contest_time',
//		'contest_user_id',
	),
)); ?>


<?php
$this->widget('ext.mailRu.MRLikeWidget',array(
	'image_src'=>$model->getImageUrl('middle', true),
));

$this->widget('ext.ok.OkLikeWidget');

$this->widget('ext.vk.VkLikeWidget');

$this->widget('ext.yaru.YaruLikeWidget');

$this->widget('ext.in.inLikeWidget');

$this->widget('ext.fb.fbLikeWidget');
?>


<div id="prizes">
<?php
$this->renderPartial('/contestPrize/list',array(
	'model'=>$prizes,
));
?>
</div>

<?php echo CHtml::link('Add Prize', array(
	'/contest/contestPrize/create',
	'id'=>$model->contest_id,
), array(
	'id'=>'addPrize',
)); ?>

<h1>Last Works</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$workDataProvider,
	'itemView'=>'/contestWork/_view',
)); ?>


<?php echo CHtml::link('Add Work', array(
	'/contest/contestWork/create',
	'id'=>$model->contest_id,
), array(
	'id'=>'addWork',
)); ?>




<?php
$this->widget('ext.fancybox.EFancyBox',array(
	'target'=>'#addPrize, #addWork, .update',
));
?>