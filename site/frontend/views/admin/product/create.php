<?php
$this->breadcrumbs=array(
	'Продукты'=>array('admin'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Администрирование', 'url'=>array('admin')),
);
?>

<h1>Создать</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>