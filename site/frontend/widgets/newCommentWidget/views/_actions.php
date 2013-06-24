<?php
/* @var $this NewCommentWidget
 * @var $data Comment
 */
$canEdit = Yii::app()->user->model->checkAuthItem('editComment') || Yii::app()->user->id == $data->author_id;
$canRemove = Yii::app()->user->model->checkAuthItem('removeComment') || Yii::app()->user->id == $data->author_id || $data->isEntityAuthor(Yii::app()->user->id);
if ($canEdit || $canRemove): ?>
    <div class="comments-gray_admin">
        <?php if ($canEdit):?>
            <div class="clearfix">
                <a href="javascript:;" class="message-ico message-ico__edit powertip"></a>
            </div>
        <?php endif ?>
        <?php if ($canRemove):?>
            <div class="clearfix">
                <a href="javascript:;" class="message-ico message-ico__del powertip" title="Удалить"></a>
            </div>
        <?php endif ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->id != $data->author_id):?>
    <div class="comments-gray_control">
        <div class="clearfix">
            <a href="javascript:;" class="comments-gray_quote-ico powertip" title="Ответить"></a>
        </div>
    </div>
<?php endif ?>