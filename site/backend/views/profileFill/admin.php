<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns' => array(
        'id',
        'email',
        array(
            'name' => 'url',
            'type' => 'raw',
            'value' => 'CHtml::link("перейти", "http://www.happy-giraffe.ru".$data->getUrl(), array("target"=>"_blank"))',
            'filter' => false
        ),
        'first_name',
        'last_name',
        array(
            'name' => 'accept',
            'type' => 'raw',
            'value' => 'CHtml::link("принять", "http://www.happy-giraffe.ru".$data->getUrl(),
                    array("id"=>"user-".$data->id,"class"=>"accept-user"))',
            'filter' => false
        )
    ),
));
?>
<script type="text/javascript">
    $('body').delegate('a.accept-user', 'click', function (e) {
        e.preventDefault();
        var id = $(this).attr('id').replace(/user-/g, '');
        var el = $(this);
        $.post('/profileFill/accept/', {id:id}, function (response) {
            if (response.status) {
                el.parents('tr').remove();
            }
        }, 'json');
    });
</script>