<?php
    $cs = Yii::app()->clientScript;
    $css = "
        div.portlet {
            width: 250px;
            border: 1px solid #000;
        }

        div.portlet-decoration {
            background: #ccc;
            border-bottom: 1px solid #000;
        }
    ";
    $js = "
        $('body').delegate('a.delete', 'click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '" . $this->createUrl('delete') . "',
                data: {
                    modelPk: $(this).parents('div.portlet').attr('id')
                },
                success: function(response) {
                    if (response == '1')
                    {
                        $(this).parents('div.portlet').remove();
                    }
                },
                context: this
            });
        });

        $('#portlets').sortable({
            stop: function(event, ui) {
                alert(ui.offset);
            }
        });
    ";
    $cs
    ->registerCss('portlets', $css)
    ->registerCoreScript('jquery.ui')
    ->registerScript('portlets', $js)
?>

<div id="portlets">
    <?php foreach ($boxes as $b): ?>
        <?php $this->widget($b->widget()->class, array(
            'model' => $b,
        )); ?>
    <?php endforeach; ?>
</div>