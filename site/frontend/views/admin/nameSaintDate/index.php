<?php
$this->breadcrumbs = array(
	'Name Saint Dates',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' NameSaintDate', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' NameSaintDate', 'url'=>array('admin')),
);
?>

<h1>Name Saint Dates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
