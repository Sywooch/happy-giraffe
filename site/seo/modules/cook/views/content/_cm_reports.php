<div class="seo-table">

    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th>Название рецепта, ссылка</th>
                <th></th>
                <th class="ac">Дата задания</th>
                <th class="ac">Дата размещения</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) { ?>
            <tr data-id="<?=$task->id ?>">
                <td><?=$task->getArticleText() ?></td>
                <td><?=$task->getMultiVarka() ?></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_PUBLICATION) ?></span></td>
                <td class="ac"><span class="date"><?=StatusDates::getTime($task, SeoTask::STATUS_PUBLISHED) ?></span></td>
            </tr>
            <?php } ?>
            </tbody></table>
    </div>

    <?php if ($pages->pageCount > 1): ?>
    <div class="pagination pagination-center clearfix">
        <?php $this->widget('MyLinkPager', array(
        'header'=>false,
        'pages' => $pages,
    )); ?>
    </div>
    <?php endif; ?>

</div>