<div class="seo-table table-report tabs">
    <div class="table-title">Список заданий</div>

    <div class="table-nav nav">
        <ul>
            <li class="new active">
                <a onclick="setTab(this, 1);" href="javascript:void(0);">Новое</a>
                <span class="count">18</span>
            </li>
            <li class="new correction">
                <a onclick="setTab(this, 2);" href="javascript:void(0);">Коррекция</a>
                <span class="count">8</span>
            </li>
            <li class="new publish">
                <a onclick="setTab(this, 3);" href="javascript:void(0);">Публикация</a>
                <span class="count">9</span>
            </li>
            <li class="new check">
                <a onclick="setTab(this, 4);" href="javascript:void(0);">Проверка</a>
                <span class="count">5</span>
            </li>
            <li class="new process">
                <a onclick="setTab(this, 5);" href="javascript:void(0);">Выполненные</a>
                <span class="count">12</span>
            </li>

        </ul>
    </div>

    <div class="tabs-container">
        <div class="table-box tab-box tab-box-1" style="display: block; ">
            <table>
                <tbody>
                <tr>
                    <th class="al">Ключевые слова и фразы</th>
                    <th>Исполнитель</th>
                    <th>Статус</th>
                </tr>

                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_READY || $task->status == SeoTask::STATUS_TAKEN) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td><?=$task->getIcon() ?></td>
                    <td class="seo-status-new-<?=$task->status ?>"><?=$task->statusText ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>



        <div class="table-box tab-box tab-box-2" style="display: block; ">
            <table>
                <colgroup>
                    <col width="400">
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <tbody><tr>
                    <th class="al">Ключевые слова и фразы</th>
                    <th class="al">Название статьи</th>
                    <th>Исполнитель</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
                <?php foreach ($tasks as $task) if ($task->status == SeoTask::STATUS_READY || $task->status == SeoTask::STATUS_TAKEN) { ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td><?=$task->getIcon() ?></td>
                    <td class="seo-status-new-<?=$task->status ?>"><?=$task->statusText ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="al">кесарева сечение<br>кесарево сечение<br>после кесарева сечения</td>
                    <td class="al"><b>Кесарево сечение - за и против</b></td>
                    <td><i class="icon-admin"></i><br><span class="admin-name">Богоявленский Александр</span></td>
                    <td class="seo-status-correction-1">Статья написана</td>
                    <td><a href="" class="btn-green-small">На коррекцию</a></td>
                </tr>
                <tr>
                    <td class="al">кесарева сечение<br>кесарево сечение<br>после кесарева сечения</td>
                    <td class="al"><b>Кесарево сечение - за и против, а также еще очень длинное название статьи</b></td>
                    <td><i class="icon-admin"></i><br><span class="admin-name">Богоявленский Александр</span></td>
                    <td class="seo-status-correction-2">На коррекции</td>
                    <td></td>
                </tr>

                </tbody></table>
        </div>
    </div>
</div>

<script type="text/javascript">
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
</script>