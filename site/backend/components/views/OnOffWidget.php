<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('body').delegate('a.activate, a.deactivate', 'click', function(e) {
            e.preventDefault();
            ConfirmPopup('Вы точно хотите ' + $(this).find('input[name=showQuestion]').val() + '  эелемент?', $(this), function (owner) {
                $.ajax({
                    type: 'POST',
                    url: '" . Yii::app()->createUrl('ajax/onOff') . "',
                    data: {
                        modelName: owner.find('input[name=modelName]').val(),
                        modelPk: owner.find('input[name=modelPk]').val()
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
                                $(this).find('input[name=showQuestion]').val('Деактивировать');
                            }
                            else
                            {
                                $(this).attr('title', 'Активировать');
                                $('.active_items ins').text(parseInt($('.active_items ins').text()) - 1);
                                $('.deactive_items ins').text(parseInt($('.deactive_items ins').text()) + 1);
                                $(this).find('input[name=showQuestion]').val('Активировать');
                            }
                            $(this).tooltip({
                                track: true,
                                delay: 0,
                                showURL: false,
                                fade: 200
                            });
                        }
                    },
                    context: owner
                });
            });
        });
    ";

    $cs->registerScript('onOffWidget', $js);
?>

<a href="#" class="<?php echo ($modelActive ? 'activate' : 'deactivate'); ?>" title="<?php echo ($modelActive ? 'Деактивировать' : 'Активировать'); ?>">
    Состояние элемента
    <?php echo CHtml::hiddenField('showQuestion', ($modelActive ? 'Деактивировать' : 'Активировать')); ?>
    <?php echo CHtml::hiddenField('modelName', $modelName); ?>
    <?php echo CHtml::hiddenField('modelPk', $modelPk); ?>
</a>