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
                <?php $this->renderPartial('_task1',array('type'=>1, 'keyword'=>$tempKeyword->keyword)); ?>
            <?php endforeach; ?>

            <?php foreach ($by_name_tasks as $by_name_task): ?>
                <?php $this->renderPartial('_task1',array('type'=>2, 'by_name_task'=>$by_name_task)); ?>
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
        $('tr').delegate('td input.example:last', 'keyup', function(e){
            $(this).parent().append('<input name="urls[]" type="text" class="example"/><br/>');
        });
    });
</script>