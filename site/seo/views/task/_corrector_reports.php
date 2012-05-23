<div class="seo-table">

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th>Название статьи</th>
                <th class="ac">Дата задания</th>
                <th class="ac">Выполнено</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) { ?>
            <tr>
                <td><?=$task->getText() ?></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_CORRECTING) ?></span></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_CORRECTED) ?></span></td>
            </tr>
            <?php } ?>
            </tbody></table>
    </div>

</div>