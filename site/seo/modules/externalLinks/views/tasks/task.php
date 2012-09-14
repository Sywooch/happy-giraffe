<div class="ext-links-add">
    <div class="tasks-count">Еще заданий сегодня <span><?=ELTask::showTaskCount() ?></span></div>
    <?php
    if (is_array($task))
        $this->renderPartial('task_1', array('tasks' => $task));
    else
        $this->renderPartial('task_' . $task->type, compact('task'));
    ?>
</div>