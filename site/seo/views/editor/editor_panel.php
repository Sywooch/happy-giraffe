<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<div class="clearfix">

    <div class="tasks-manager">

        <div class="drag-text">
            <span class="arrow"></span>
            Перетащите<br/>СЮДА<br/>слова
        </div>

        <div class="tasks-list">

        </div>

        <div class="buttons">
            <div class="admins">
                <a href="" class="btn-admins" onclick="$(this).next().toggle();return false;"></a>
                <ul style="display: none;">
                    <?php foreach (Yii::app()->user->getModel()->authors as $author): ?>
                        <?php if (Yii::app()->authManager->checkAccess('author', $author->id)):?>
                            <li><a href="" onclick="TaskDistribution.addGroup(2, <?php echo $author->id ?>,0);$(this).parents('ul').hide();return false;"><?=$author->name ?></a></li>
                        <?php endif ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="" class="btn-moderators" onclick="TaskDistribution.addGroup(1, '', 0);return false;"></a>
        </div>

    </div>

    <div class="seo-table table-tasks">
        <div class="table-box">
            <table>
                <tr>
                    <th class="col-1">Ключевое слово или фраза</th>
                    <th>Частота</th>
                    <th>Действие</th>
                </tr>
                <?php foreach ($tempKeywords as $tempKeyword): ?>
                <tr id="keyword-<?=$tempKeyword->keyword->id ?>"<?php if (!empty($tempKeyword->keyword->keywordGroups)) echo ' style="display:none;"' ?>>
                    <td class="col-1">
                        <div class="item"><div class="drag"></div>
                            <span><?=$tempKeyword->keyword->name ?></span>
                        </div>
                    </td>
                    <td><span><i class="icon-freq-1"></i></span> <span class="freq-val">10,5</span></td>
                    <td><a href="" class="btn-green-small" onclick="TaskDistribution.addToGroup($(this));return false;">Ok</a>
                        <a href="" class="icon-remove" onclick="TaskDistribution.removeFromSelected(this);return false;"></a></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<div class="seo-table current-tasks">
    <div class="table-box">
        <table>
            <tr>
                <th>Ключевое слово или фраза</th>
                <th>Исполнитель</th>
                <th>Действие</th>
            </tr>
            <?php foreach($tasks as $task)
                    $this->renderPartial('_distrib_task', array('task' => $task)); ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.seo-table .item').draggable({
            handle:'.drag',
            revert:true
        });

        $('.tasks-manager').droppable({
            drop:function (event, ui) {
                //ui.draggable.parents('tr').hide();
                TaskDistribution.addToGroup(ui.draggable);
            }
        });
    });
</script>