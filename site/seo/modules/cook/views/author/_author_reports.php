<?php
/* @var $this Controller
 * @var $task SeoTask
 */
?><div class="seo-table table-report">
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
                <th class="al">Название рецепта, ссылка</th>
                <th class="al">Ключевое слово</th>
                <th></th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
            <?php foreach ($tasks as $task) { ?>
            <tr>
                <td class="al"><?=$task->getArticleText() ?></td>
                <td class="al"><?=$task->getKeywordsText() ?></td>
                <td><?=$task->getMultiVarka() ?></td>
                <td class="seo-status-author-<?=$task->status ?>"><?=$task->statusText ?></td>
                <td>
                    Написан <span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_WRITTEN) ?></span>
                    <?php if ($task->status >= SeoTask::STATUS_PUBLISHED): ?>
                    Размещен <span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_PUBLISHED) ?></span>
                    <?php endif ?>
                </td>
            </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>