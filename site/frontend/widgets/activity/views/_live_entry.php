<li>
    <div class="date"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created); ?></div>
    <div class="user">
        <?php if ($data->author->id == User::HAPPY_GIRAFFE):?>
            <span>Веселый Жираф</span>
        <?php else: ?>
            <span class="icon-status status-<?php echo $data->author->online == 1 ? 'online' : 'offline'; ?>"></span>
            <?=CHtml::link($data->author->fullName, $data->author->url)?>
        <?php endif ?>
    </div>
    <?=CHtml::link($data->title, $data->url)?>
    <?=$data->short?>
</li>