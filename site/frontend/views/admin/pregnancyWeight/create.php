<?php
$this->breadcrumbs=array(
	'Pregnancy Weights'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PregnancyWeight', 'url'=>array('index')),
	array('label'=>'Manage PregnancyWeight', 'url'=>array('admin')),
);
?>

<h1>Create PregnancyWeight</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>