<?php
    $cs = Yii::app()->clientScript;

    $js = "
        function check(element, id, mark) {
            $.ajax({
                url: '/ajax/setValue/',
                type: 'post',
                data: {
                    entity: 'CommunityContent',
                    entity_id: id,
                    attribute: 'edited',
                    value: mark,
                },
                success: function(response) {
                    if (response == '1') {
                        var post = $(element).parents('tr').find('td:first-child > a');

                        if (mark == 1) {
                            post.wrapInner('<s />');
                            $(element).children('img').attr('src', '/images/cross.png');
                        } else {
                            post.children('s').contents().unwrap();
                            $(element).children('img').attr('src', '/images/tick.png');
                        }
                    }

                    $(element).parents('tr').remove();
                }
            });
            return false;
        }
    ";

    $cs->registerScript('rewrite', $js, CClientScript::POS_HEAD);
?>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dp,
        'selectableRows' => 0,
        'columns' => array(
            array(
                'header' => 'Статья',
                'value' => 'CHtml::link($data->title, $data->url, array("target" => "_blank"))',
                'type' => 'raw',
            ),
            array(
                'header' => 'Ответственный',
                'value' => 'CHtml::link($data->editor->fullName, $data->editor->url, array("target" => "_blank"))',
                'type' => 'raw',
            ),
            array(
                'header' => 'Редактировать',
                'class' =>'CButtonColumn',
                'template' => '{update}',
                'buttons'=>array(
                    'update' => array(
                        'url' => 'Yii::app()->createUrl("community/edit", array("content_id" => $data->id))',
                    ),
                ),
            ),
            array(
                'value' => 'CHtml::link(CHtml::image("/images/tick.png"), "#", array("onclick" => "check(this, $data->id, 2)")) . " " . CHtml::link(CHtml::image("/images/cross.png"), "#", array("onclick" => "check(this, $data->id, 0)"))',
                'type' => 'raw',
            ),
        ),
    ));
