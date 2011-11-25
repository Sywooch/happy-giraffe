<?php
$this->breadcrumbs = array(
	'Community Videos',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' CommunityVideo', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' CommunityVideo', 'url'=>array('admin')),
);
?>

<h1>Community Videos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
