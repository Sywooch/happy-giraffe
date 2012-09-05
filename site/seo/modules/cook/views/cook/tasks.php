<?php
/* @var $this Controller
 * @var $tempKeywords TempKeyword[]
 * @var $tasks SeoTask[]
 * @var $tasks SeoTask[]
 */
Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

<script type="text/javascript">
    $(function() {
        $('body').delegate('input.example:last', 'keyup', function(e){
            $(this).parent().append('<input name="urls[]" type="text"/><br/>');
        });
    });
</script>

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
                <tr>
                    <td class="al"><?=$tempKeyword->keyword->name ?> </td>
                    <td width="300">
                        <input type="text" name="urls[]" class="example" /><br/>
                    </td>
                    <td><input type="checkbox" /></td>
                    <td>
                        <div class="btn-cooks-container">

                            <a href="" class="btn-cooks" onclick="$(this).next().toggle();return false;"></a>
                            <ul style="display: none;">
                                <?php
                                $users = SeoUser::model()->findAll('owner_id = '.Yii::app()->user->id);
                                foreach ($users as $author): ?>
                                    <?php if (Yii::app()->authManager->checkAccess('cook-author', $author->id)):?>
                                        <li><a href="" onclick="TaskDistribution.addGroup(2, <?php echo $author->id ?>,0);$(this).parents('ul').hide();return false;"><?=$author->name ?></a></li>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ($tempKeywords as $tempKeyword): ?>
            <tr>
                <td class="al"><?=$tempKeyword->keyword->name ?> </td>
                <td width="300">
                    <input type="text" name="urls[]" class="example" /><br/>
                </td>
                <td><input type="checkbox" /></td>
                <td>
                    <div class="btn-cooks-container">

                        <a href="" class="btn-cooks" onclick="$(this).next().toggle();return false;"></a>
                        <ul style="display: none;">
                            <?php
                            $users = SeoUser::model()->findAll('owner_id = '.Yii::app()->user->id);
                            foreach ($users as $author): ?>
                                <?php if (Yii::app()->authManager->checkAccess('cook-author', $author->id)):?>
                                    <li><a href="" onclick="TaskDistribution.addGroup(2, <?php echo $author->id ?>,0);$(this).parents('ul').hide();return false;"><?=$author->name ?></a></li>
                                    <?php endif ?>
                                <?php endforeach; ?>
                        </ul>
                    </div>
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

            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td class="al"><?=$task->getText() ?> <?php if (empty($task->keyword_group_id)):?><span class="sup-h">H</span><?php endif ?></td>
                    <td><?php if ($task->multivarka):?><span class="icon-m">M</span><?php endif ?></td>
                    <td><?=$task->getExecutor() ?></td>
                    <td>
                        <a href="javascript:;" class="icon-remove" onclick="TaskDistribution.removeTask(this)"></a>
                        <a href="javascript:;" class="icon-return" onclick="TaskDistribution.returnTask(this)"></a>
                        <a href="javascript:;" class="btn-green-small" onclick="TaskDistribution.readyTask(this)">Ok</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>
