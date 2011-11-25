<?php
$this->breadcrumbs = array(
	'Comments',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' Comment', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' Comment', 'url'=>array('admin')),
);
?>

<h1>Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
