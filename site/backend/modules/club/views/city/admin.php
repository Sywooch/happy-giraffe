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
        $('a.decl_checked').click(function () {
            var id = $(this).prev().val();
            var self = $(this);
            $.post('/club/city/checked/', {id:id}, function (response) {
                self.parents('tr').remove();
            }, 'json');

            return false;
        })
    });
</script>