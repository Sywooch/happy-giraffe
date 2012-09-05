<?php foreach ($tasks as $task): ?>
    <div class="status-<?=$task->status ?>">
        <?= $task->getText() ?>
        <input type="text" value="" size="100">
        <a href="#" onclick="SeoModule.Executed(<?=$task->id ?>, this);return false;">OK</a>
    </div>
    <?php endforeach; ?>

<?php foreach ($success_tasks as $task): ?>
<div>
    <?= $task->getText() ?> - <?= $task->executed ?>
</div>
<?php endforeach; ?>