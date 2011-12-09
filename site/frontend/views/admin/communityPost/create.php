<?php
$this->breadcrumbs=array(
	'Community Posts'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>'List CommunityPost', 'url'=>array('index')),
	array('label'=>'Manage CommunityPost', 'url'=>array('admin')),
);
?>

<h1> Create CommunityPost </h1>
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
	<?php echo CHtml::submitButton(Yii::t('app', 'Create')); ?>
</div>

<?php $this->endWidget(); ?>

</div>
