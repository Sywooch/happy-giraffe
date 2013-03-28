<h1>Склонения городов</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'geo-city-grid',
    'dataProvider' => $model->declensionSearch(),
    'filter' => $model,
    'columns' => array(
        'id',
        'name',
        'name_from',
        'name_between',
        array(
            'type' => 'raw',
            'value' => '$data->declCheckedLink()',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}'
        ),
    ),
));
?>
<script type="text/javascript">
    $(function () {
        $('body').delegate('a.decl_checked', 'click', function(e){
            var id = $(this).prev().val();
            var self = $(this);
            $.post('/geo/city/checked/', {id:id}, function (response) {
                self.parents('tr').remove();
            }, 'json');

            return false;
        });
    });
</script>