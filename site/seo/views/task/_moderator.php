<?php if (!$executing)
foreach ($tasks as $task): ?>
<div class="status-<?=$task->status ?>">
    <?= $task->getText() ?> - <a href="#" onclick="SeoModule.TakeTask(<?=$task->id ?>);return false;">Take it!</a>
</div>
<?php endforeach; ?>

<?php if ($executing):?>
    <div>
        <?= $executing->getText() ?>
        <input type="text" value="" size="100">
        <a href="#" onclick="SeoModule.Executed(<?=$executing->id ?>, this);return false;">OK</a>
    </div>
<?php endif ?>

<?php foreach ($success_tasks as $task): ?>
<div>
    <?= $task->getText() ?> - <?= $task->executed ?>
</div>
<?php endforeach; ?>

<script type="text/javascript">
    $(function() {
        Comet.prototype.TaskTaken = function (result, id) {
            window.location.reload();
        }
        comet.addEvent(200, 'TaskTaken');
    });
</script>