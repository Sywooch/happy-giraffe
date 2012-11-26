<?php
/**
 * Author: alexk984
 * Date: 21.11.12
 */
?>
<?php if (!empty($model->birthday)) echo $form->hiddenField($model, 'birthday'); ?>
<div class="row clearfix">
    <div class="row-title">
        <label>Пол:</label>
    </div>
    <div class="row-elements">
        <?=$form->radioButtonList($model, 'gender', array(1 => 'Мужской', 0 => 'Женский'), array(
        'template' => '{input}{label}',
        'separator' => '',
    )); ?>
    </div>
    <div class="row-error">
        <i class="error-ok"></i>
        <?=$form->error($model, 'gender'); ?>
    </div>
</div>