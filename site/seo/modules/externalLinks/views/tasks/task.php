<div class="tasks-count">Еще заданий сегодня <span><?=ELTask::showTaskCount() ?></span></div>
<?php $this->renderPartial('task_'.$task->type,compact('task')); ?>