<?php
/** @var $task ELTask
 */

Yii::app()->clientScript->registerScript('init_site_id','ExtLinks.site_id = '.$task->site_id);
?>
<div class="tasks-list">

    <ul>
        <li>
            <div class="task-title">Поставьте комментарий на форуме
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

        <?php $this->renderPartial('_problem',compact('task')); ?>

    </div>

</div>