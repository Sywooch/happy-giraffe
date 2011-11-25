<?php
$this->breadcrumbs=array(
	'Возрасты'=>array('admin'),
	$model->range_title,
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Администрирование', 'url'=>array('admin')),
);
?>

<h1>Редактирование <?php echo $model->range_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>