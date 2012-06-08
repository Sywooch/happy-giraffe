<div class="seo-table">
    <div class="table-title">Данные для работы</div>
    <div class="table-box">
        <table>
            <tbody>
            <tr>
                <th>Название статьи</th>
                <th class="ac">Дата задания</th>
                <th class="ac">Действие</th>
            </tr>
            <?php foreach ($tasks as $task) { ?>
            <tr>
                <td><?=$task->getText() ?></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_CORRECTING) ?></span></td>
                <td class="ac"><a class="btn-green-small" href="" onclick="SeoTasks.Corrected(this, <?=$task->id ?>);return false;">Откорректировано</a></td>
            </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>