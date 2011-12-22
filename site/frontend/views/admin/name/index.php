<?php
$this->breadcrumbs = array(
	'Names',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Name', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Name', 'url'=>array('admin')),
);
?>

<h1>Names</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
