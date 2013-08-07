<?php
/**
 * @var SeoTask $task
 */
?><div class="seo-table table-report tabs">
    <div class="table-title">Список заданий</div>

    <div class="table-nav nav">
        <?php $this->renderPartial('reports_menu', array('status'=>$status)); ?>
    </div>

    <div class="tabs-container">
        <div class="table-box tab-box tab-box-3" style="display: none; ">
            <table>
                <colgroup>
                    <col width="400">
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th class="al">Ключевые слова и фразы</th>
                    <th class="al">Название статьи</th>
                    <th>Исполнитель</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($models as $task) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td class="al"><?=$task->getArticleText() ?></td>
                    <td><?=$task->getExecutor() ?></td>
                    <td class="seo-status-publish-<?=($task->status == SeoTask::STATUS_WRITTEN)?1:2 ?>"><?=$task->getStatusText() ?></td>
                    <?php if ($task->status == SeoTask::STATUS_WRITTEN): ?>
                    <td><a href="" class="btn-green-small" onclick="SeoTasks.ToPublishing(this, <?=$task->id ?>);return false;">На публикацию</a></td>
                    <?php else: ?>
                    <td></td>
                    <?php endif ?>
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