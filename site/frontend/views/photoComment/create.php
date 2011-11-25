<?php
$this->breadcrumbs=array(
	'Photo Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PhotoComment', 'url'=>array('index')),
	array('label'=>'Manage PhotoComment', 'url'=>array('admin')),
);
?>

<h1>Create PhotoComment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>