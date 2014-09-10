<?php
/* @var $this NewCommentWidget
 * @var $data Comment
 */
?>
<div class="comments-gray_i<?php if ($data->author_id == Yii::app()->user->id) echo ' comments-gray_i__self' ?>">

    <?php $this->render('_like',compact('data')); ?>

    <div class="comments-gray_ava">
        <?php $this->widget('Avatar', array('user' => $data->author, 'size' => 24)) ?>
    </div>

    <div class="comments-gray_frame">
        <div class="comments-gray_header clearfix">
            <a href="" class="comments-gray_author"><?=$data->author->getFullName() ?></a>
            <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created)?></span>
        </div>
        <div class="comments-gray_cont wysiwyg-content">
            <?=$data->purified->text ?>
        </div>
    </div>

    <?php $this->render('_actions', compact('data')); ?>

</div>