<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('body').delegate('a.delete', 'click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '" . Yii::app()->createUrl('ajax/delete') . "',
                data: {
                    class: $(this).find('input[name=modelName]').val(),
                    id: $(this).find('input[name=modelPk]').val()
                },
                success: function(response) {
                    if (response == '1')
                    {
                        $(this).parents('tr').remove();
                    }
                },
                context: $(this)
            });
        });
    ";

    $cs->registerScript('deleteWidget', $js);
?>

<a href="#delete_category" class="delete" title="Удалить <?php echo $model->accusativeName; ?>">
    <img src="/images/icons/delete_sm_icon.png" alt="Удалить <?php echo $model->accusativeName; ?>"/>
    <?php echo CHtml::hiddenField('modelName', get_class($model)); ?>
    <?php echo CHtml::hiddenField('modelPk', $model->primaryKey); ?>
</a>