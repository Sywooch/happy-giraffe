<?php
$this->breadcrumbs = array(
	'Community Comments',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' CommunityComment', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' CommunityComment', 'url'=>array('admin')),
);
?>

<h1>Community Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
