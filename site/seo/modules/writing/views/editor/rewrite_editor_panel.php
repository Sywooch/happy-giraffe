<?php
/* @var $this Controller
 * @var $tempKeywords TempKeyword[]
 */
Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
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
                    <?php foreach ($authors as $author): ?>
                        <li>
                            <a href="" onclick="TaskDistribution.addGroup(2, <?php echo $author->id ?>,1);$(this).parents('ul').hide();return false;"><?=$author->name ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="javascript:;" class="btn-moderators" onclick="TaskDistribution.addGroup(1, '', 1)"></a>
            <a href="javascript:;" class="btn-commentators" onclick="TaskDistribution.addGroup(3, '', 0)"></a>
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
                <tr data-id="<?=$tempKeyword->keyword->id; ?>"
                    id="keyword-<?=$tempKeyword->keyword->id ?>"<?php if (!empty($tempKeyword->keyword->group)) echo ' style="display:none;"' ?>>
                    <td class="col-1">
                        <div class="item">
                            <div class="drag"></div>
                            <span><?=$tempKeyword->keyword->name ?></span>
                        </div>
                    </td>
                    <td><span><?=$tempKeyword->keyword->getFreqIcon() ?></span> <span
                            class="freq-val"><?= $tempKeyword->keyword->getRoundFrequency() ?></span></td>
                    <td>
                        <a href="javascript:;" class="btn-green-small"
                           onclick="TaskDistribution.addToGroup($(this))">Ok</a>
                        <a href="javascript:;" class="icon-remove"
                           onclick="TaskDistribution.removeFromSelected(this)"></a>
                        <br>
                        <a href="javascript:;"
                           onclick="TaskDistribution.changeSection(this, <?=$tempKeyword->keyword->id ?>, 2)">Асе в
                            Кулинарию</a>&nbsp;
                        <br>
                        <a href="javascript:;"
                           onclick="TaskDistribution.changeSection(this, <?=$tempKeyword->keyword->id ?>, 3)">Асе в
                            Рукоделие</a>
                    </td>
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
                <th>Примеры</th>
                <th>Исполнитель</th>
                <th width="110">Действие</th>
            </tr>
            <?php foreach ($tasks as $task)
            $this->renderPartial('_distrib_task', array('task' => $task)); ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.seo-table .item').draggable({
            handle:'.drag',
            revert:true
        });

        $('.tasks-manager').droppable({
            drop:function (event, ui) {
                TaskDistribution.addToGroup(ui.draggable);
            }
        });

        $('body').delegate('.current-tasks input.example', 'keyup', function () {
            if (!$(this).next().hasClass('tick-link'))
                $(this).after('<a class="tick-link" href="javascript:;"></a>');

            if (!$(this).next().next().next().hasClass('example'))
                $(this).next().next().after('<input name="urls[]" type="text" class="example"/><br/>');
        });

        $('body').delegate('a.tick-link', 'click', function () {
            var id = $(this).prev().data('id');
            var task_id = $(this).parents('tr').data('id');
            var url = $(this).prev().val();
            $.ajax({
                url:'/writing/editor/rewriteUrl/',
                data:{id:id, task_id:task_id, url:url},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.deleted){
                        $(this).prev().remove();
                        $(this).next().remove();
                        $(this).remove();
                    }
                    else{
                        if (response.status) {
                            $(this).prev().data('id', response.id);
                            $(this).remove();
                        } else
                            $.pnotify({
                                pnotify_title:'Ошибка',
                                pnotify_type:'error',
                                pnotify_text:'Обратитесь к разработчикам'
                            });
                    }
                },
                context:$(this)
            });
        });
    });
</script>
<style type="text/css">
    #seo .current-tasks {
        width: auto;
    }
</style>