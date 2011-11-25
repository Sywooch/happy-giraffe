<?php
$this->breadcrumbs = array(
	'Points Histories',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' PointsHistory', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' PointsHistory', 'url'=>array('admin')),
);
?>

<h1>Points Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
