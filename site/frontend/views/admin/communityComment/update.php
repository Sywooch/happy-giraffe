<?php
$this->breadcrumbs=array(
	'Community Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List CommunityComment', 'url'=>array('index')),
	array('label'=>'Create CommunityComment', 'url'=>array('create')),
	array('label'=>'View CommunityComment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CommunityComment', 'url'=>array('admin')),
);
?>

<h1> Update CommunityComment #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-comment-form',
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
