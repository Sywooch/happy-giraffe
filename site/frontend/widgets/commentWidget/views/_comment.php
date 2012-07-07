<?php
/* @var $this Controller
 * @var $data Comment
 */
if ($data->author_id == 1): ?>
    <?php //if (!empty($data->photoAttaches)):?>
        <?php //$data->photoAttach->getContent(); ?>
    <?php //endif ?>
    <img src="/images/happy_giraffe_comment.jpg" alt="Веселый Жираф приветствует вас!">
<?php else: ?>
<?php if ($data->removed == 0): ?>
    <li class="clearfix item<?php if ($data->author_id == Yii::app()->user->id) echo ' author-comment' ?>" id="comment_<?php echo $data->id; ?>">
        <div class="comment-in clearfix">
            <div class="header clearfix">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->author, 'friendButton' => true, 'location' => false)); ?>
            </div>
            <?php $this->render($this->type . '_comment', array('type' => $this->type, 'data' => $data, 'currentPage' => $currentPage)); ?>
        </div>
        <div class="comment-action">

        </div>
    </li>
    <?php elseif($this->type != 'guestBook'): ?>
    <div class="removed-comment content-in">
        <?= $data->getRemoveDescription() ?>
    </div>
    <?php endif; ?>
<?php endif; ?>