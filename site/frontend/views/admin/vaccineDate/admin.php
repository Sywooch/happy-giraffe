<?php
$this->breadcrumbs=array(
	'Vaccine Dates'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app',
				'List VaccineDate'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create VaccineDate'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('vaccine-date-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> Manage&nbsp;Vaccine Dates</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vaccine-date-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'vaccine.name',
		'time_from',
		'time_to',
		array(
		    'name'=>'interval',
		    'value'=>'$data->GetTimeInterval()',
		),
        'adult',
		'every_period',
		'age_text',
		array(
		    'name'=>'vaccination_type',
		    'value'=>'$data->vaccine_type_names[$data->vaccination_type]',
		),
		'vote_decline',
		'vote_agree',
		'vote_did',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
