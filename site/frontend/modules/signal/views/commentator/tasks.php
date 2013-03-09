<?php
/**
 * @var SeoTask[] $tasks
 */
?>
<div id="popup-keywords" class="popup popup-keywords">

    <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>
    <table>
        <tbody>
        <tr>
            <th class="col-1">Ключевые слова и фразы</th>
            <th>Показов <br>в месяц</th>
            <th></th>
        </tr>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td class="col-1"><?=$task->keywordGroup->keywords[0]->name?></td>
            <td><?=$task->keywordGroup->keywords[0]->wordstat?></td>
            <td><a href="javascript:;" onclick="CommentatorPanel.TakeTask(<?=$task->id ?>)" class="btn-green-small">Взять</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
