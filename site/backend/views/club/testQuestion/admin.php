<h1>Manage Test Questions</h1>

<!--<?php echo CHtml::link('создать', array('club/TestQuestion/create')) ?>-->
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'test-question-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'test_id',
        array(
            'name' => 'title',
            'value' => 'CHtml::link ( CHtml::encode ( $data->title ),  array ( "club/TestQuestion/update", "id" => $data->id ) )',
            'type' => 'raw'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}'
        ),
    ),
)); ?>
