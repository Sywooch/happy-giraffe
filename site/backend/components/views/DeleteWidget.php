<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('body').delegate('a.delete', 'click', function(e) {
            e.preventDefault();
            ConfirmPopup('Вы точно хотите ' + $(this).find('img').attr('alt'), $(this), function (owner) {
            $.ajax({
                type: 'POST',
                url: '" . Yii::app()->createUrl('ajax/delete') . "',
                data: {
                    modelName: owner.find('input[name=modelName]').val(),
                    modelPk: owner.find('input[name=modelPk]').val()
                },
                success: function(response) {
                    if (response == '1')
                    {
                        $(this).parents('" . $selector . "').remove();

                        if ($(this).find('input[name=modelIsTree]').val() == '1')
                        {
                            $(this).parents('li:eq(1)').remove();
                        }

                        " . $onSuccess . "
                    }
                },
                context: owner
            });
            });
        });
    ";

    $cs->registerScript('deleteWidget', $js);
?>

<a class="delete" title="Удалить <?php echo $modelAccusativeName; ?>">
    <img src="/images/icons/delete_sm_icon.png" alt="Удалить <?php echo $modelAccusativeName; ?>"/>
    <?php echo CHtml::hiddenField('modelName', $modelName); ?>
    <?php echo CHtml::hiddenField('modelPk', $modelPk); ?>
    <?php echo CHtml::hiddenField('modelIsTree', $modelIsTree); ?>
</a>