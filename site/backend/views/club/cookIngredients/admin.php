<h1>Manage Cook Ingredients</h1>

<?php echo CHtml::link('создать', array('club/CookIngredients/create')) ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cook-ingredients-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'value' => '$data->category->title',
            'header' => 'Категория'
        ),
        array(
            'value' => '$data->unit->title',
            'header' => 'Ед.изм.'
        ),
        'title',
        'weight',
        'density',
        //'src',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>
