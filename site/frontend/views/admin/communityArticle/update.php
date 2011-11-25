<?php
$this->breadcrumbs=array(
	'Community Articles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List CommunityArticle', 'url'=>array('index')),
	array('label'=>'Create CommunityArticle', 'url'=>array('create')),
	array('label'=>'View CommunityArticle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CommunityArticle', 'url'=>array('admin')),
);
?>

<h1> Update CommunityArticle #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-article-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('app', 'Update')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
