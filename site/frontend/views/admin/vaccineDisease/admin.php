<?php
$this->breadcrumbs=array(
	'Vaccine Diseases'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app',
				'List VaccineDisease'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create VaccineDisease'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('vaccine-disease-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> Manage&nbsp;Vaccine Diseases</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vaccine-disease-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'name_genitive',
        array(
            'name'=>'disease_id',
            'value'=>'isset($data->disease)?$data->disease->name:""',
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
