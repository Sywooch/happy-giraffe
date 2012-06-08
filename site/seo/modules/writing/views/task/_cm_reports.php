<div class="seo-table">

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th>Название статьи</th>
                <th class="ac">Дата задания</th>
                <th class="ac">Дата размещения</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) { ?>
            <tr>
                <td><?=$task->getArticleText() ?></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_PUBLICATION) ?></span></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_PUBLISHED) ?></span></td>
            </tr>
            <?php } ?>
            </tbody></table>
    </div>

</div>