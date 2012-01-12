<?php
$this->breadcrumbs=array(
	'Name Famouses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NameFamous', 'url'=>array('index')),
	array('label'=>'Manage NameFamous', 'url'=>array('admin')),
);
?>

<h1>Create NameFamous</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>