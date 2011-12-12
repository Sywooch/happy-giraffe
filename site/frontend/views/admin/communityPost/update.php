<?php
$this->breadcrumbs=array(
	'Community Posts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List CommunityPost', 'url'=>array('index')),
	array('label'=>'Create CommunityPost', 'url'=>array('create')),
	array('label'=>'View CommunityPost', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CommunityPost', 'url'=>array('admin')),
);
?>

<h1> Update CommunityPost #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-post-form',
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
