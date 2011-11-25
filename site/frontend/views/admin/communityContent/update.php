<?php
$this->breadcrumbs=array(
	'Community Contents'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>'List CommunityContent', 'url'=>array('index')),
	array('label'=>'Create CommunityContent', 'url'=>array('create')),
	array('label'=>'View CommunityContent', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CommunityContent', 'url'=>array('admin')),
);
?>

<h1> Update CommunityContent #<?php echo $model->id; ?> </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-content-form',
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
