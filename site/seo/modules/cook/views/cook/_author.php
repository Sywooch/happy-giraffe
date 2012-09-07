<div class="btn-cooks-container">

    <a href="" class="btn-cooks" onclick="$(this).next().toggle();return false;"></a>
    <ul style="display: none;">
        <?php
        $users = SeoUser::model()->findAll('owner_id = '.Yii::app()->user->id);
        foreach ($users as $author): ?>
            <?php if (Yii::app()->authManager->checkAccess('cook-author', $author->id)):?>
                <li><a href="" onclick="CookModule.addTask(this, <?php echo $author->id ?>);$(this).parents('ul').hide();return false;"><?=$author->name ?></a>
                    <span class="count"><?=$author->getTasksCount() ?></span></li>
                <?php endif ?>
            <?php endforeach; ?>
    </ul>
</div>