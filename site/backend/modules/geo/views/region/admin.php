<h1>Регионы</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'geo-region-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'country_id',
            'value' => '$data->country->name',
        ),
        'name',
        'google_name',
        'type',
        /*
        'center_id',
        'position',
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
        $('body').delegate('a.region_checked', 'click', function(e){
            var id = $(this).prev().val();
            var self = $(this);
            $.post('/geo/region/checked/', {id:id}, function (response) {
                $.fn.yiiGridView.update('geo-region-grid');
            }, 'json');

            return false;
        });
    });
</script>
