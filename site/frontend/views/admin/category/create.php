<?php
$this->breadcrumbs=array(
	'Категории'=>array('admin'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Создать</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>