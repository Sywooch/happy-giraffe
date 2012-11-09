<?php
/** @var $task ELTask
 */

Yii::app()->clientScript->registerScript('init_site_id','ExtLinks.site_id = '.$task->site_id);
?>
<div class="tasks-list">

    <ul>
        <li>
            <div class="task-title">Зарегистрируйтесь и поставьте комментарий на форуме
                <a target="_blank" href="http://<?=$task->site->url?>">
                    <span class="hl">http://<?=$task->site->url?></span>
                </a>
            </div>
        </li>
        <?php if (empty($task->site->account)): ?>
        <li>
            <div class="task-title">Внесите данные регистрации</div>
            <?php $this->renderPartial('/forums/_reg_data'); ?>
        </li>
        <?php else: ?>
        <li>
            <a href="javascript:;" class="pseudo" onclick="$(this).next().toggle()">Показать данные</a>

            <?php $this->renderPartial('/forums/_reg_data', array('show'=>false, 'account'=>$task->site->account)); ?>
        </li>
        <?php endif ?>
    </ul>

</div>

<div class="form">

    <div class="row row-btn-done">

        <button class="btn-g" onclick="ExtLinks.Executed(<?=$task->id ?>)">Выполнено</button>
        <div class="problem">
            <a href="javascript:void(0);" class="pseudo" onclick="$(this).next().toggle()">Возникла проблема</a>

            <div class="problem-in" style="display: none;">
                <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>

                <?php if (empty($task->site->account)): ?>
                <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 1)">В черный список</a>
                <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 2)">Отложить на 3 дня</a>
                <?php else: ?>
                    <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 1)">В черный список</a>
                    <a href="javascript:;" class="radio" onclick="ExtLinks.checkProblem(this, 2)">Отложить на 3 дня</a>
                <?php endif ?>

            </div>
            <div class="problem-in" style="display: none;">
                <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Problem(<?=$task->id ?>)">Ok</a>
            </div>
        </div>

    </div>

</div>