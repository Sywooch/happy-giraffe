<?php
/* @var $tasks SeoTask[]
 * @var $executing SeoTask
 */
?><?php if (!$executing) {    ?>
<div class="seo-table">
    <div class="table-title">Список текущих заданий</div>
    <div class="table-box">
        <table>
            <tbody><tr>
                <th>Название рецепта или ключевое слово</th>
                <th></th>
                <th class="ac">Действие</th>
            </tr>
                <?php foreach ($tasks as $task){ ?>
                <tr>
                    <td class="al"><?=$task->getText() ?></td>
                    <td><?=$task->getMultiVarka() ?></td>
                    <td class="ac"><a href="" class="btn-green-small" onclick="SeoTasks.TakeTask(<?=$task->id ?>);return false;">Взять в работку</a></td>
                </tr>
                    <?php } ?>
            </tbody></table>
    </div>
</div>
<?php }?>

<?php if ($executing):?>
<div class="seo-table">
    <div class="table-title">Данные для работы</div>
    <div class="table-box">
        <table>
            <tbody><tr>
                <th>Название рецепта или ключевое слово</th>
                <th></th>
                <th>Примеры</th>
            </tr>
            <tr>
                <td><?=$executing->getText() ?></td>
                <td><?=$executing->getMultiVarka() ?></td>
                <td><?=$executing->getUrlsText() ?></td>
            </tr>
            </tbody></table>
    </div>
</div>

<div class="article-ready">
    <div class="block-title">Введите название рецепта</div>

    <input type="text" value="">
    <button class="btn-green" onclick="CookModule.written(<?=$executing->id ?>, this)">Готово</button>
</div>
<?php endif; ?>
