<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('body').delegate('a.activate, a.deactivate', 'click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '" . Yii::app()->createUrl('ajax/onOff') . "',
                data: {
                    modelName: $(this).find('input[name=modelName]').val(),
                    modelPk: $(this).find('input[name=modelPk]').val()
                },
                success: function(response) {
                    if (response == '1')
                    {
                        $(this).toggleClass('activate deactivate');
                        if ($(this).hasClass('activate'))
                        {
                            $(this).attr('title', 'Деактивировать');
                            $('.active_items ins').text(parseInt($('.active_items ins').text()) + 1);
                            $('.deactive_items ins').text(parseInt($('.deactive_items ins').text()) - 1);
                        }
                        else
                        {
                            $(this).attr('title', 'Активировать');
                            $('.active_items ins').text(parseInt($('.active_items ins').text()) - 1);
                            $('.deactive_items ins').text(parseInt($('.deactive_items ins').text()) + 1);
                        }
                        $(this).tooltip({
                            track: true,
                            delay: 0,
                            showURL: false,
                            fade: 200
                        });
                    }
                },
                context: $(this)
            });
        });
    ";

    $cs->registerScript('onOffWidget', $js);
?>

<a href="#" class="<?php echo ($modelActive ? 'activate' : 'deactivate'); ?>" title="<?php echo ($modelActive ? 'Деактивировать' : 'Активировать'); ?>">
    Состояние элемента
    <?php echo CHtml::hiddenField('modelName', $modelName); ?>
    <?php echo CHtml::hiddenField('modelPk', $modelPk); ?>
</a>