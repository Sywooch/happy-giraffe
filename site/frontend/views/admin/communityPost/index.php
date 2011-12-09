<?php
$this->breadcrumbs = array(
	'Community Posts',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' CommunityPost', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' CommunityPost', 'url'=>array('admin')),
);
?>

<h1>Community Posts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
