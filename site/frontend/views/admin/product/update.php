<?php
$this->breadcrumbs=array(
	'Продукты'=>array('admin'),
	$model->product_title=>$model->getUrl(),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Просмотр', 'url'=>$model->getUrl()),
	array('label'=>'Администрирование', 'url'=>array('admin')),
);
?>

<h1>Редактирование <?php echo $model->product_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>