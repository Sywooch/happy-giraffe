<?php
$this->breadcrumbs = array(
	'Recipe Book Diseases',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>'Создать болезнь', 'url'=>array('create')),
	array('label'=>'Управление болезнями', 'url'=>array('admin')),
);
?>

<h1>Справочник болезней</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
