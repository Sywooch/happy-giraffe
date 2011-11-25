<?php
$this->breadcrumbs = array(
	'Vaccine Diseases',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' VaccineDisease', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' VaccineDisease', 'url'=>array('admin')),
);
?>

<h1>Vaccine Diseases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
