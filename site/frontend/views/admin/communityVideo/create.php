<?php
$this->breadcrumbs=array(
	'Community Videos'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List CommunityVideo', 'url'=>array('index')),
	array('label'=>'Manage CommunityVideo', 'url'=>array('admin')),
);
?>

<h1> Create CommunityVideo </h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-video-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
