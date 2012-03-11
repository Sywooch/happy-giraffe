<h1>Гороскоп</h1>

<?php echo CHtml::link('создать', array('/club/horoscope/create')) ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'horoscope-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'ajaxUpdate'=>false,
    'columns' => array(
        array(
            'name' => 'zodiac',
            'value' => '$data->zodiacText()',
            'filter' => Horoscope::model()->zodiac_list
        ),
        array(
            'name' => 'date',
            'value' => '$data->dateText()',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'language'=>'',
                'attribute'=>'date',
                //'htmlOptions'=>array('class'=>'input date', 'placeholder'=>'Date from', 'id'=>'date_from'),
                'options'=>array(
                    'dateFormat'=> 'dd-mm-yy',
                )
            ),  true)
        ),
        'text',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
