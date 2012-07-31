<h1>Календарь малыша</h1>


<?php $model->calendar = 0; $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'calendar-period-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        array(
            'name' => 'title',
            'value' => 'CHtml::link ( CHtml::encode ( $data->title ),  array ( "update", "id" => $data->id ) )',
            'type'=>'raw'
        ),
        array(
            'name' => 'text',
            'value' => 'Str::truncate(strip_tags($data->text))',
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}'
        ),
    ),
)); ?>