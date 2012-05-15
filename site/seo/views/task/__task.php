<div class="status-<?=$task->status ?>" id="task-<?=$task->id ?>">
    <?= $task->getText() ?>
    <?php if ($task->status == SeoTask::STATUS_PUBLISHED):?>
        <a href="#" onclick="SeoModule.CloseTask(<?=$task->id ?>);return false;">проверено, закрыть задание</a>
    <?php endif ?>

    <?php if ($task->status == SeoTask::STATUS_WRITTEN):?>
    <a href="#" onclick="SeoModule.ToPublishing(<?=$task->id ?>);return false;">проверено, передать на размещение</a>
    <?php endif ?>
</div>