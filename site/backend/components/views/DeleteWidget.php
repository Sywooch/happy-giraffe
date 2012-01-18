<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('body').delegate('a.delete', 'click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '" . Yii::app()->createUrl('ajax/delete') . "',
                data: {
                    modelName: $(this).find('input[name=modelName]').val(),
                    modelPk: $(this).find('input[name=modelPk]').val()
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

<a class="delete" title="Удалить <?php echo $model->accusativeName; ?>">
    <img src="/images/icons/delete_sm_icon.png" alt="Удалить <?php echo $model->accusativeName; ?>"/>
    <?php echo CHtml::hiddenField('modelName', get_class($model)); ?>
    <?php echo CHtml::hiddenField('modelPk', $model->primaryKey); ?>
</a>