<?php $tasks = SeoTask::model()->findAll('owner_id=' . Yii::app()->user->id);
foreach ($tasks as $task): ?>
<div class="status-<?=$task->status ?>">
    <?= $task->getText() ?>
</div>
<?php endforeach; ?>
