<?php if ($recipe->more): ?>
<div class="cook-more clearfix">
    <div class="block-title">
        Еще вкусненькое
    </div>
    <ul class="clearfix">
        <?php foreach ($recipe->more as $m): ?>
        <li>
            <div class="content">
                <?=$m->getPreview(243)?>
            </div>
            <div class="item-title"><?=CHtml::link($m->title, $m->url)?></div>
            <div class="user clearfix">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $m->author, 'size' => 'small', 'location' => false, 'sendButton' => false, 'hideLinks'=>true, 'online_status'=>false)); ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>