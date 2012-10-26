<h1>Баннеры</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'cook-spices-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        array(
            'name' => 'content_id',
            'value' => 'CHtml::link($data->content->title, $data->content->url)',
            'type' => 'raw',
        ),
        array(
            'name'=>'photo_id',
            'value'=>'$data->getImage()',
            'type'=>'raw'
        ),
        array(
            'name' => 'class',
            'value'=>'$data->colors[$data->class]',
            'type' => 'raw',
        ),
        'title',
        array(
            'header' => 'Сообщество',
            'value'=>'$data->content->rubric->community->title',
            'type' => 'raw',
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>
