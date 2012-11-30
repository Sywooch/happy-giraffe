<div class="seo-table table-report tabs">
    <div class="table-title">Список заданий</div>

    <div class="table-nav nav">
        <?php $this->renderPartial('reports_menu', array('status'=>$status)); ?>
    </div>

    <div class="tabs-container">
        <div class="table-box tab-box tab-box-1">
            <table>
                <thead>
                <tr>
                    <th class="al">Ключевые слова и фразы</th>
                    <th>Исполнитель</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($models as $task) { ?>
                <tr data-id=<?=$task->id ?>>
                    <td class="al"><?=$task->getText() ?></td>
                    <td><?=$task->getExecutor() ?></td>
                    <td class="seo-status-new-<?=$task->status ?>"><?=$task->statusText ?></td>
                </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

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