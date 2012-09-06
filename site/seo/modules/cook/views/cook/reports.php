<?php
/* @var $this Controller
 * @var $tasks SeoTask[]
 */
?><div class="seo-table table-report tabs">
    <div class="table-title">Список заданий</div>

    <div class="table-nav nav">
        <ul>
            <li class="new active">
                <a onclick="setTab(this, 1);" href="javascript:void(0);">Новое</a>
                <span class="count"></span>
            </li>
            <li class="new correction">
                <a onclick="setTab(this, 2);" href="javascript:void(0);">Коррекция</a>
                <span class="count"></span>
            </li>
            <li class="new publish">
                <a onclick="setTab(this, 3);" href="javascript:void(0);">Публикация</a>
                <span class="count"></span>
            </li>
            <li class="new check">
                <a onclick="setTab(this, 4);" href="javascript:void(0);">Проверка</a>
                <span class="count"></span>
            </li>
            <li class="new process">
                <a onclick="setTab(this, 5);" href="javascript:void(0);">Выполненные</a>
                <span class="count"></span>
            </li>

        </ul>
    </div>

    <div class="tabs-container">
        <div class="table-box tab-box tab-box-1" style="display: block; ">
            <table>
                <thead>
                <tr>
                    <th class="al">Название рецепта или<br>ключевое слово</th>
                    <th>Примеры</th>
                    <th></th>
                    <th>Кулинар</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_READY || $task->status == SeoTask::STATUS_TAKEN) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td><?=$task->getUrlsText() ?></td>
                    <td><?=$task->getMultiVarka() ?></td>
                    <td><?=$task->executor->name ?></td>
                    <td class="seo-status-new-<?=$task->status ?>"><?=$task->statusText ?></td>
                </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="table-box tab-box tab-box-2" style="display: none; ">
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
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_WRITTEN || $task->status == SeoTask::STATUS_CORRECTING) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td class="al"><?=$task->getArticleText() ?></td>
                    <td><?=$task->getExecutor() ?></td>
                    <td class="seo-status-correction-<?=($task->status == SeoTask::STATUS_WRITTEN) ? 1 : 2 ?>"><?=$task->statusText ?></td>
                    <?php if ($task->status == SeoTask::STATUS_WRITTEN): ?>
                    <td><a href="" class="btn-green-small"
                           onclick="SeoTasks.ToCorrection(this, <?=$task->id ?>);return false;">На коррекцию</a></td>
                    <?php else: ?>
                    <td></td>
                    <?php endif ?>
                </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

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
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_CORRECTED || $task->status == SeoTask::STATUS_PUBLICATION) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td class="al"><?=$task->getArticleText() ?></td>
                    <td><?=$task->getExecutor() ?></td>
                    <td class="seo-status-publish-<?=($task->status == SeoTask::STATUS_CORRECTED) ? 1 : 2 ?>"><?=$task->statusText ?></td>
                    <?php if ($task->status == SeoTask::STATUS_CORRECTED): ?>
                    <td><a href="" class="btn-green-small"
                           onclick="SeoTasks.ToPublishing(this, <?=$task->id ?>);return false;">На публикацию</a></td>
                    <?php else: ?>
                    <td></td>
                    <?php endif ?>
                </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>

        <div class="table-box tab-box tab-box-4" style="display: none; ">
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
                    <th class="al">Опубликованные статьи</th>
                    <th>Исполнитель</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_PUBLISHED) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td class="al"><?=$task->getArticleText() ?></td>
                    <td><?=$task->getExecutor() ?></td>
                    <td><a href="" class="btn-green-small"
                           onclick="SeoTasks.CloseTask(this, <?=$task->id ?>);return false;">Проверено</a></td>
                </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="table-box tab-box tab-box-5" style="display: none; ">
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
                    <th class="al">Опубликованные статьи</th>
                    <th>Исполнитель</th>
                    <th>Дата завершения</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_CLOSED) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td class="al"><?=$task->getArticleText() ?></td>
                    <td><?=$task->getExecutor() ?></td>
                    <td><?=StatusDates::getTime($task, SeoTask::STATUS_CLOSED) ?></td>
                </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(function () {
        calcTaskCount();
    });

    function setTab(el, num) {
        var tabs = $(el).parents('.tabs');
        var li = $(el).parent();
        if (!li.hasClass('active')) {
            tabs.find('li').removeClass('active');
            li.addClass('active');
            tabs.find('.tab-box-' + num).fadeIn();
            tabs.find('.tab-box').not('.tab-box-' + num).hide();

        }
    }

    function calcTaskCount() {
        $('div.table-box').each(function (index, Element) {
            var tabs_count = $(this).find('tr').length - 1;
            $('.table-nav li:eq(' + index + ') span.count').html(tabs_count);
        });
    }
</script>