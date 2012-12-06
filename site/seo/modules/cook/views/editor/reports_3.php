<div class="seo-table table-report tabs">
    <div class="table-title">Список заданий</div>

    <div class="table-nav nav">
        <?php $this->renderPartial('reports_menu', array('status'=>$status, 'section'=>$section)); ?>
    </div>

    <div class="tabs-container">
        <div class="table-box tab-box tab-box-3" style="display: none; ">
            <table id="publish-table">
                <colgroup>
                    <col width="400">
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th class="al">Название рецепта</th>
                    <th class="al">Ключевое слово</th>
                    <th></th>
                    <th>Кулинар</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task){ ?>
                <tr>
                    <td class="al"><?=$task->article_title ?></td>
                    <td class="al"><?=$task->getKeywordsText() ?></td>
                    <td><?=$task->getMultiVarka() ?></td>
                    <td><?=$task->executor->name ?></td>
                    <td class="seo-status-publish-2"><?=$task->statusText ?></td>
                    <td>
                        <?php if ($_GET['section'] == 2):?>
                        <a href="javascript:;" onclick="CookModule.changeSection(this, <?=$task->id ?>, 3)">В рукоделие</a>
                        <?php elseif($_GET['section'] == 3): ?>
                        <a href="javascript:;" onclick="CookModule.changeSection(this, <?=$task->id ?>, 2)">В кулинарию</a>
                        <?php endif ?>
                    </td>
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