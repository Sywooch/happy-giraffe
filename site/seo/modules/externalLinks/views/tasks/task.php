<div class="ext-links-add">

    <?php if (Yii::app()->user->checkAccess('externalLinks-manager-panel')): ?>
    <?php $this->renderPartial('/forums/sub_menu') ?>
    <?php endif ?>

    <div class="ext-links-add">
        <div class="tasks-count">Еще заданий сегодня <span><?=ELTask::model()->getTaskLimit() - ELTask::model()->todayTaskCount() ?></span></div>
        <?php
        if (is_array($task))
            $this->renderPartial('task_reg', array('tasks' => $task));
        else
            $this->renderPartial('task_' . $task->type, compact('task'));
        ?>
    </div>

</div>