<h1>Тематики</h1>

<?=CHtml::link('создать', array('create'))?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sites-group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}'
        ),
	),
)); ?>
