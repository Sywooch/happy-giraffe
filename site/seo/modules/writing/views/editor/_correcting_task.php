<tr>
    <td class="al"><?=$task->getText() ?></td>
    <td class="al"><?=$task->getArticleText() ?></td>
    <td><?=$task->getExecutor() ?></td>
    <td class="seo-status-correction-<?=($task->status == SeoTask::STATUS_WRITTEN)?1:2 ?>"><?=$task->statusText ?></td>
    <?php if ($task->status == SeoTask::STATUS_WRITTEN): ?>
        <td><a href="" class="btn-green-small" onclick="SeoTasks.ToCorrection(this, <?=$task->id ?>);return false;">На коррекцию</a></td>
    <?php else: ?>
        <td></td>
    <?php endif ?>
</tr>