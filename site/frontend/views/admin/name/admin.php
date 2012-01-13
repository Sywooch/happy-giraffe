<?php
$this->breadcrumbs = array(
    'Names' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Name', 'url' => array('index')),
    array('label' => 'Create Name', 'url' => array('create')),
);
?>

<h1>Имена</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'name-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'name',
        array(
            'name' => 'gender',
            'value' => '$data->GenderText()',
        ),
        'translate',
        array(
            'name' => 'origin',
            'value' => '$data->GetShort("origin")',
        ),
        array(
            'name' => 'description',
            'value' => '$data->GetShort("description")',
        ),
        /*
          'options',
          'sweet',
          'middle_names',
          'likes',
          */
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
