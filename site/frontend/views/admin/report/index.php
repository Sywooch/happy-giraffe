<?php
$this->breadcrumbs = array(
	'Reports',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Report', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Report', 'url'=>array('admin')),
);
?>

<h1>Reports</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
