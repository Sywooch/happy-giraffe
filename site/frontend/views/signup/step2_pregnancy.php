<?php
/**
 * @var $form CActiveForm
 * @var $model User
 */
?>
<div class="clearfix row-date">
    <div class="row clearfix" style="display: inline-block;">
        <div class="row-title">
            <label>Пол:</label>
        </div>
        <div class="row-elements">
            <?=$form->radioButtonList($model, 'gender', array(1 => 'Мужской', 0 => 'Женский'), array(
            'template' => '{input}{label}',
            'separator' => '',
        )); ?>
        </div>
        <br>

        <div class="row-error">
            <i class="error-ok"></i>
            <?=$form->error($model, 'gender'); ?>
        </div>
    </div>

    <div class="row clearfix" style="display: inline-block;">
        <div class="row-title">
            <label>Предполагаемая дата родов:</label>
        </div>
        <div class="row-elements">
            <span class="chzn-v2"><?=$form->dropDownList($model, 'baby_day', HDate::Range(1, 31), array('class' => 'chzn', 'empty' => 'День', 'style' => 'width:60px;')); ?></span>
            <span class="chzn-v2"><?=$form->dropDownList($model, 'baby_month', HDate::ruMonths(), array('class' => 'chzn', 'empty' => 'Месяц', 'style' => 'width:80px;')); ?></span>
            <span class="chzn-v2"><?=$form->dropDownList($model, 'baby_year', HDate::Range(date('Y'), date('Y')+1), array('class' => 'chzn', 'empty' => 'Год', 'style' => 'width:60px;')); ?></span>
            <?=$form->textField($model, 'baby_birthday', array('style' => 'display:none;')); ?>
        </div>
        <br>

        <div class="row-error">
            <i class="error-ok"></i>
            <?= $form->error($model, 'baby_birthday'); ?>
        </div>
    </div>
</div>