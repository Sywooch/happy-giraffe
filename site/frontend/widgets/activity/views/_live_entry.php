<li>
    <div class="date"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created); ?></div>
    <div class="user">
        <span class="icon-status status-<?php echo $data->author->online == 1 ? 'online' : 'offline'; ?>"></span>
        <?=CHtml::link($data->author->fullName, $data->author->url)?>
    </div>
    <?=CHtml::link($data->title, $data->url)?>
    <?=$data->short?>
</li>