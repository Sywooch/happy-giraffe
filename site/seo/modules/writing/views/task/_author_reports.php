<div class="seo-table table-report">
    <div class="table-box">
        <table>
            <colgroup>
                <col width="400">
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th class="al">Ключевые слова и фразы</th>
                <th class="al">Название статьи, ссылка</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
            <?php foreach ($tasks as $task) { ?>
            <tr>
                <td class="al"><?=$task->getText() ?></td>
                <td class="al"><?=$task->getArticleText() ?></td>
                <td class="seo-status-author-<?=$task->status ?>"><?=$task->statusText ?></td>
                <td>
                    Написана <span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_WRITTEN) ?></span>
                    <?php if ($task->status >= SeoTask::STATUS_PUBLISHED): ?>
                    Размещена <span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_PUBLISHED) ?></span>
                    <?php endif ?>
                </td>
            </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>