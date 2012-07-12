<h1>Гороскоп</h1>

<?php echo CHtml::link('создать', array('horoscope/create')) ?>
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
            'name' => 'year',
            'filter' => HDate::Range(2012, date('Y'))
        ),
        array(
            'name' => 'month',
            'value' => 'HDate::ruMonth($data->month)',
            'filter' => HDate::ruMonths()
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
                    'dateFormat'=> 'yy-mm-dd',
                )
            ),  true)
        ),
        array(
            'name'=>'text',
            'value'=>'Str::truncate($data->text, 100)',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
