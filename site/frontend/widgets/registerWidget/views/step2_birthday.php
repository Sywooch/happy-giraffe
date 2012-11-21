<?php
/**
 * @var $form CActiveForm
 * @var $model User
 */
?><div class="clearfix row-date">
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
        <div class="row-elements">
                            <span
                                    class="chzn-v2"><?=$form->dropDownList($model, 'day', HDate::Range(1, 31), array('class' => 'chzn', 'empty' => 'День', 'style' => 'width:60px;')); ?></span>
                            <span
                                    class="chzn-v2"><?=$form->dropDownList($model, 'month', HDate::ruMonths(), array('class' => 'chzn', 'empty' => 'Месяц', 'style' => 'width:80px;')); ?></span>
                            <span
                                    class="chzn-v2"><?=$form->dropDownList($model, 'year', HDate::Range(date('Y') - 18, 1900), array('class' => 'chzn', 'empty' => 'Год', 'style' => 'width:60px;')); ?></span>
            <?=$form->textField($model, 'birthday', array('style' => 'display:none;')); ?>
        </div>
        <br>

        <div class="row-error">
            <i class="error-ok"></i>
            <?= $form->error($model, 'birthday'); ?>
        </div>
    </div>
</div>