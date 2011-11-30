<?php
$this->breadcrumbs=array(
	'Vaccine Dates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List VaccineDate', 'url'=>array('index')),
	array('label'=>'Create VaccineDate', 'url'=>array('create')),
	array('label'=>'Update VaccineDate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VaccineDate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VaccineDate', 'url'=>array('admin')),
);
?>

<h1>View VaccineDate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vaccine_id',
		'time_from',
		'time_to',
		'adult',
		'interval',
		'every_period',
		'age_text',
		'vaccination_type',
		'vote_decline',
		'vote_agree',
		'vote_did',
        'comment'
	),
)); ?>


<br /><h2> Болезни: </h2>
<ul><?php foreach($model->diseases as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->name, array('vaccinedisease/view', 'id' => $foreignobj->id)));

				} ?></ul>