<h1>Manage Query Search Engines</h1>

<?php echo CHtml::link('создать', array('/admin/QuerySearchEngine/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'query-search-engine-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name'=>'query_id',
            'value'=>'$data->query_id."  ".$data->query->keyword->name',
        ),
        array(
            'name' => 'se_id',
            'value' => '$data->getSe()',
            'filter' => array(2 => 'yandex', 3 => 'google')
        ),
        'visits',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
