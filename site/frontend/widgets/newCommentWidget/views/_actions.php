<?php
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
                <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                    'model' => $data,
                    'callback' => 'function() {'.$this->objectName.'.remove();}',
                    'author' => Yii::app()->user->id == $data->author_id || $data->isEntityAuthor(Yii::app()->user->id),
                    'cssClass'=>'message-ico message-ico__del powertip'
                )); ?>
            </div>
        <?php endif ?>
    </div>
<?php endif; ?>