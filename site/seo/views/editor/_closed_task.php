<tr>
    <td class="al"><?=$task->getText() ?></td>
    <td class="al"><b><?=$task->getArticleText() ?></b></td>
    <td><?=$task->getExecutor() ?></td>
    <td><?=StatusDates::getTime($task, SeoTask::STATUS_CLOSED) ?></td>
</tr>