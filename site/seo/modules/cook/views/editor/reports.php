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
                    <th></th>
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


        <div class="table-box tab-box tab-box-2" style="display: none; ">
            <table>
                <thead>
                <tr>
                    <th class="al">Название рецепта</th>
                    <th class="al">Ключевое слово</th>
                    <th></th>
                    <th>Кулинар</th>
                    <th>Действие</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_WRITTEN) { ?>
                <tr>
                    <td class="al"><?=$task->article_title ?></td>
                    <td class="al"><?=$task->getKeywordsText() ?></td>
                    <td><?=$task->getMultiVarka() ?></td>
                    <td><?=$task->executor->name ?></td>
                    <td><a href="javascript:;" class="btn-green-small"
                           onclick="CookModule.toPublishing(this, <?=$task->id ?>);">На публикацию</a></td>
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
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_PUBLICATION) { ?>
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

        <div class="table-box tab-box tab-box-4" style="display: none; ">
            <table>
                <thead>
                <tr>
                    <th class="al">Опубликованный рецепт, ссылка</th>
                    <th class="al">Ключевое слово</th>
                    <th></th>
                    <th>Кулинар</th>
                    <th>Действие</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_PUBLISHED) { ?>
                <tr>
                    <td class="al"><?=$task->getArticleText() ?></td>
                    <td class="al"><?=$task->getKeywordsText() ?></td>
                    <td><?=$task->getMultiVarka() ?></td>
                    <td><?=$task->executor->name ?></td>
                    <td><a href="" class="btn-green-small"
                           onclick="SeoTasks.CloseTask(this, <?=$task->id ?>);return false;">Проверено</a>
                    </td>
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


        <div class="table-box tab-box tab-box-5" style="display: none; ">
            <table>
                <thead>
                <tr>
                    <th class="al">Опубликованный рецепт, ссылка</th>
                    <th class="al">Ключевое слово</th>
                    <th></th>
                    <th>Кулинар</th>
                    <th>Дата завершения</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_CLOSED) { ?>
                <tr>
                    <td class="al"><?=$task->getArticleText() ?></td>
                    <td class="al"><?=$task->getKeywordsText() ?></td>
                    <td><?=$task->getMultiVarka() ?></td>
                    <td><?=$task->executor->name ?></td>
                    <td><?=StatusDates::getTime($task, SeoTask::STATUS_CLOSED) ?></td>
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