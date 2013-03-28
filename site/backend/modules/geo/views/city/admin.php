<h1>Города</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'geo-city-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'country_id',
            'value' => '$data->country->name',
        ),
        array(
            'name' => 'region_id',
            'value' => '$data->region->name',
        ),
        array(
            'name' => 'district_id',
            'value' => 'isset($data->district)?$data->district->name:""',
        ),
        'name',
        'type',
        /*
        'weather_id',
        'name_from',
        'name_between',
        'auto_created',
        'declension_checked',
        */
        array(
            'name' => 'auto_created',
            'value' => '$data->getStatus()',
            'type'=>'raw',
            'filter' => array(1 => 'не проверены'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>
<script type="text/javascript">
    $(function () {
        $('body').delegate('a.city_checked', 'click', function (e) {
            var id = $(this).prev().val();
            var self = $(this);
            $.post('/geo/city/checked/', {id:id}, function (response) {
                $.fn.yiiGridView.update('geo-city-grid');
            }, 'json');

            return false;
        });
    });
</script>