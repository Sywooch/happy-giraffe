<h1>Ингредиенты</h1>

<?php echo CHtml::link('создать', array('cookIngredients/create')) ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cook-ingredients-grid',
    'dataProvider' => $model->search(),
    'filter' => null,
    'columns' => array(
        'id',
        array(
            'name' => 'title',
            'type'=>'raw'
        ),
        array(
            'value' => '$data->category->title',
            'header' => 'Категория'
        ),
        array(
            'value' => '$data->unit->title',
            'header' => 'Ед.изм. по умолч.'
        ),
        array(
            'name'=>'textNutritional',
            'type'=>'raw',
        ),
        array(
            'name'=>'density',
            'value'=>'(float)$data->density',
        ),
        'textUnits',
        'textSynonyms',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>