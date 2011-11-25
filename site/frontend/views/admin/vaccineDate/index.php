<?php
$this->breadcrumbs = array(
	'Vaccine Dates',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' VaccineDate', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' VaccineDate', 'url'=>array('admin')),
);
?>

<h1>Vaccine Dates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
