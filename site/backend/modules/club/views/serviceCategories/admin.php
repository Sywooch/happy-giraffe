<h1>Категории сервисов</h1>

<?=CHtml::link('Cоздать', array('create'))?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'service-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'title',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>