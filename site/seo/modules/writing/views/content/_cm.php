<div class="seo-table">
    <div class="table-title">Данные для работы</div>
    <div class="table-box">
        <table>
            <tbody><tr>
                <th>Название статьи</th>
                <th class="ac">Дата задания</th>
                <th class="ac">Размещение</th>
            </tr>

            <?php foreach ($tasks as $task){ ?>
            <tr>
                <td><?=$task->getText() ?></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_PUBLICATION) ?></span></td>
                <td class="ac"><input type="text" class="placing">
                    <a href="" class="btn-green-small" onclick="SeoTasks.Published(this, <?=$task->id ?>);return false;">Ok</a></td>
            </tr>
                <?php } ?>

            </tbody></table>
    </div>
</div>