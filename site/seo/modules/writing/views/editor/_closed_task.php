<tr data-id="<?=$task->id ?>">
    <td class="al"><?=$task->getText() ?></td>
    <td class="al"><?=$task->getArticleText() ?></td>
    <td><?=$task->getExecutor() ?></td>
    <td><?=StatusDates::getTime($task, SeoTask::STATUS_CLOSED) ?></td>
</tr>