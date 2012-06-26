<h1>Шаблоны рассылки</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'columns' => array(
        'title',
        'action',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view} {update}'
        ),
    ),
));
?>