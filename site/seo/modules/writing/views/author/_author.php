<?php if (!$executing) {    ?>
<div class="seo-table">
    <div class="table-title">Список текущих заданий</div>
    <div class="table-box">
        <table>
            <tbody><tr>
                <th>Ключевое слово или фраза</th>
                <?php if (Yii::app()->user->checkAccess('rewrite-author')):?>
                    <th>Примеры</th>
                <?php endif ?>
                <th class="ac">Действие</th>
            </tr>
                <?php foreach ($tasks as $task){ ?>
                <tr>
                    <td><?=$task->getText() ?></td>
                    <?php if (Yii::app()->user->checkAccess('rewrite-author')):?>
                        <td><?=$task->getUrlsText() ?></td>
                    <?php endif ?>
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
                <th>Ключевое слово или фраза</th>
                <?php if (Yii::app()->user->checkAccess('rewrite-author')):?>
                    <th>Примеры</th>
                <?php endif ?>
                <th>Подсказки</th>
            </tr>
            <tr>
                <td><?=$executing->getText() ?></td>
                <?php if (Yii::app()->user->checkAccess('rewrite-author')):?>
                    <td><?=$executing->getUrlsText() ?></td>
                <?php endif ?>
                <td><?=$executing->getHints() ?></td>
            </tr>
            </tbody></table>
    </div>
</div>


<div class="article-ready">

    <span class="text">После того, как Вы передали готовую статью<br>шеф-редактору, нажмите кнопку</span>
    <a href="" class="btn-green" onclick="SeoTasks.Written(<?=$executing->id ?>, this);return false;">Готово</a>

</div>
<?php endif; ?>
