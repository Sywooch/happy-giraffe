<form action="">
    <?php if (isset($user_id)):?>
        <?= CHtml::hiddenField('user_id', $user_id) ?>
    <?php endif ?>

    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name' => 'date',
    'language' => 'ru',
    'options' => array(
        'showAnim' => 'fold',
        'dateFormat' => 'yy-mm-dd',
    ),
    'htmlOptions' => array(
        'style' => 'height:20px;'
    ),
)); ?>

    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name' => 'last_date',
    'language' => 'ru',
    'options' => array(
        'showAnim' => 'fold',
        'dateFormat' => 'yy-mm-dd',
    ),
    'htmlOptions' => array(
        'style' => 'height:20px;'
    ),
)); ?>
    <?= CHtml::submitButton('GO'); ?>
</form>