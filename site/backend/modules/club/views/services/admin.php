<h1>Сервисы</h1>

<?=CHtml::link('Cоздать', array('create'))?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'service-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'title',
        'description',
        'url',
        array(
            'name' => 'photo_id',
            'value' => '$data->getImage()',
            'type' => 'raw'
        ),
        array(
            'name' => 'community_id',
            'value' => '($data->community) ? $data->community->title : ""',
            'type' => 'raw'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>