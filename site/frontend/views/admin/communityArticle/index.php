<?php
$this->breadcrumbs = array(
	'Community Articles',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' CommunityArticle', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' CommunityArticle', 'url'=>array('admin')),
);
?>

<h1>Community Articles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
