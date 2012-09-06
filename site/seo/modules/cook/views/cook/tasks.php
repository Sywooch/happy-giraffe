<?php
/* @var $this Controller
 * @var $tempKeywords TempKeyword[]
 * @var $tasks SeoTask[]
 * @var $by_name_tasks SeoTask[]
 */
Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<div class="seo-table table-cook">
    <div class="table-box">
        <table>
            <tr>
                <th class="al">Название рецепта или<br/>ключевое слово</th>
                <th width="300">Примеры</th>
                <th>Мульт.</th>
                <th>Кулинар</th>
            </tr>
            <?php foreach ($tempKeywords as $tempKeyword): ?>
                <tr data-key_id="<?=$tempKeyword->keyword_id ?>">
                    <td class="al"><?=$tempKeyword->keyword->name ?> </td>
                    <td width="300">
                        <input type="text" name="urls[]" class="example" /><br/>
                    </td>
                    <td><input type="checkbox" name="multivarka" /></td>
                    <td>
                        <?php $this->renderPartial('_author'); ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ($by_name_tasks as $by_name_task): ?>
            <tr data-task_id="<?=$by_name_task->id ?>">
                <td class="al"><?=$by_name_task->article_title ?></td>
                <td width="300">
                    <?php $this->renderPartial('_urls', array('urls'=>$by_name_task->urls)); ?>
                </td>
                <td><input type="checkbox" name="multivarka" /></td>
                <td>
                    <?php $this->renderPartial('_author'); ?>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>

<br/>

<div class="seo-table table-tasks current-tasks table-green">
    <div class="table-box">
        <table>
            <tr>
                <th class="al">Название рецепта или<br/>ключевое слово</th>
                <th></th>
                <th>Кулинар</th>
                <th>Действие</th>
            </tr>

            <?php foreach ($tasks as $task)
                $this->renderPartial('_task2',compact('task')); ?>

        </table>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('body').delegate('input.example:last', 'keyup', function(e){
            $(this).parent().append('<input name="urls[]" type="text" class="example"/><br/>');
        });
    });
</script>