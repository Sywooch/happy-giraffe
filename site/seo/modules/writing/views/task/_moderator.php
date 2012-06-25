<?php Yii::app()->clientScript
    ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/comet.js')
    ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/dklab_realplexor.js')
    ->registerScript('Realplexor-reg', 'comet.connect(\'http://' . Yii::app()->comet->host . '\', \'' . Yii::app()->comet->namespace . '\', \'' . SeoUserCache::GetCurrentUserCache() . '\');'); ?>
<?php if (!$executing) {    ?>
    <div class="seo-table">
    <div class="table-title">Список текущих заданий</div>
        <div class="table-box">
        <table>
            <tbody><tr>
                <th>Ключевое слово или фраза</th>
                <th class="ac">Действие</th>
            </tr>
    <?php foreach ($tasks as $task){ ?>
            <tr>
                <td><?=$task->getText() ?></td>
                <td class="ac"><a href="" class="btn-green-small" onclick="SeoTasks.TakeTask(<?=$task->id ?>);return false;">Взять в обработку</a></td>
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
                <th>Подсказки</th>
            </tr>
            <tr>
                <td><?=$executing->getText() ?></td>
                <td><?=$executing->getText() ?></td>
            </tr>
            </tbody></table>
    </div>
</div>

<div class="article-ready">
    <div class="block-title">Введите адрес готовой статьи</div>
    <input type="text" value="">
    <button class="btn-green-big" onclick="SeoTasks.Written(<?=$executing->id ?>, this);return false;">Готово</button>
</div>
<?php endif ?>

<script type="text/javascript">
    $(function() {
        Comet.prototype.TaskTaken = function (result, id) {
            window.location.reload();
        }
        comet.addEvent(200, 'TaskTaken');
    });
</script>