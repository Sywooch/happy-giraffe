<?php
/**
 * @var $comment_id int
 * @author Alex Kireev <alexk984@gmail.com>
 */
$comment = Comment::model()->findByPk($comment_id);
?>
<div class="user-notice-list_post js-powertip-white" data-powertip="<?= $comment->getPowerTipTitle() ?>">
    <div class="user-notice-list_ava clearfix">
        <span class="ava <?=Yii::app()->user->getModel()->gender?'male':'female' ?> small"><img src="<?=Yii::app()->user->getModel()->getAva('small') ?>"></span>
    </div>
    <div class="user-notice-list_comment">
        <div class="user-notice-list_comment-text">
            <?=Str::truncate($comment->purified->text, 230) ?>
        </div>
    </div>
</div>