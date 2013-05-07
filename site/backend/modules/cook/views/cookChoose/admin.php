<h1>Статьи "Как выбрать"</h1>

<?php echo CHtml::link('создать', array('create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cook-choose-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'title',
            'value' => 'CHtml::link ( CHtml::encode ( $data->title ),  array ( "update", "id" => $data->id ) )',
            'type' => 'raw'
        ),
        array(
            'name' => 'category_id',
            'value' => '$data->category->title',
            'type' => 'raw'
        ),
        array(
            'name' => 'photo_id',
            'value' => '$data->getImage()',
            'type' => 'raw'
        ),
        /*'title_accusative',
          'desc',
          'desc_quality',
          'desc_defective',
          'desc_check',
          */
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>
