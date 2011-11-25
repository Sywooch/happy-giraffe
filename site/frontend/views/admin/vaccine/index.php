<?php
$this->breadcrumbs = array(
	'Vaccines',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Vaccine', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Vaccine', 'url'=>array('admin')),
);
?>

<h1>Vaccines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
