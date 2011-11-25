<?php
$this->breadcrumbs=array(
	'Бренды'=>array('index'),
	$model->brand_title,
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Администрирование', 'url'=>array('admin')),
);
?>

<h1>Редактировать <?php echo $model->brand_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>