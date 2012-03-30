<?php if ($data->removed == 0): ?>
<li class="clearfix item" id="comment_<?php echo $data->id; ?>">
    <div class="clearfix">
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->author, 'friendButton' => true)); ?>
        </div>
        <?php $this->render($this->type . '_comment', array('type' => $this->type, 'data' => $data, 'currentPage'=>$currentPage)); ?>
    </div>
    <div class="comment-action">

    </div>
</li>
<?php else: ?>
<div class="removed-comment content-in">
    <?= $data->getRemoveDescription() ?>
</div>
<?php endif; ?>
