<?php
/* @var $this Controller
 * @var $data Comment
 */
?>
<?php if ($data->author_id == 1): ?>
    <?php if (!empty($data->photoAttaches)):?>
        <?= $data->photoAttach->getContent(true); ?>
    <?php endif ?>
<?php else: ?>
    <?php if ($data->removed == 0): ?>
        <li class="clearfix item<?php if ($data->author_id == Yii::app()->user->id) echo ' author-comment' ?>" id="comment_<?php echo $data->id; ?>">
            <div class="comment-in clearfix">
                <div class="header clearfix">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->author, 'friendButton' => true, 'location' => false, 'hideLinks'=>true)); ?>
                </div>
                <?php $this->render($this->type . '_comment', array('type' => $this->type, 'data' => $data, 'currentPage' => $currentPage)); ?>
            </div>
            <div class="comment-action">

            </div>
        </li>
    <?php else: ?>

        <?php if ($index == 0 || $dp->data[$index - 1]->removed == 0): ?>

            <?php
                $comments = array();
                for ($i = $index; $i == $index || (isset($dp->data[$i]) && $dp->data[$i]->removed == 1); $i++) {
                    $comments[] = $dp->data[$i];
                    $last = $i;
                }
            ?>

            <div class="removed-comment content-in">
                <?=Comment::model()->getGroupRemoveDescription($comments, $index + 1, $last + 1)?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>