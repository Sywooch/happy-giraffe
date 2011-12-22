<?php
$this->breadcrumbs = array(
	'Name Groups',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' NameGroup', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' NameGroup', 'url'=>array('admin')),
);
?>

<h1>Name Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
