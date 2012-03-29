<li class="clearfix item" id="comment_<?php echo $data->id; ?>">
    <div class="clearfix">
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->author, 'friendButton' => true)); ?>
        </div>
        <div class="content">
            <div class="meta">
                <span class="date"><?php echo HDate::GetFormattedTime($data->created, ', '); ?></span>
            </div>
            <?php if ($data->removed == 0): ?>
                <div class="content-in">
                    <?php echo $data->text; ?>
                </div>
                <?php if (!Yii::app()->user->isGuest): ?>
                    <div class="actions">
                        <?php
                        if ($data->author->id != Yii::app()->user->id) {
                            $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
                            $report->button("$(this).parents('.item').find('.comment-action')");
                            $this->endWidget();
                        }
                        ?>
                        <?php if (Yii::app()->user->checkAccess('editComment', array('user_id' => $data->author->id)) || Yii::app()->user->checkAccess('removeComment', array('user_id' => $data->author->id)) || $data->isEntityAuthor(Yii::app()->user->id)): ?>
                        <div class="admin-actions">
                            <?php if (Yii::app()->user->checkAccess('editComment', array('user_id' => $data->author->id))): ?>
                            <?php echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit', 'onclick' => 'return Comment.edit(this);')); ?>
                            <?php endif; ?>
                            <?php if (Yii::app()->user->checkAccess('removeComment', array('user_id' => $data->author->id)) || $data->isEntityAuthor(Yii::app()->user->id)): ?>
                            <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                                'model' => $data,
                                'callback' => 'Comment.remove',
                                'author' => Yii::app()->user->id == $data->author->id || $data->isEntityAuthor(Yii::app()->user->id)
                            )); ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="content-in">
                    <?php if ($data->remove->type == 0): ?>
                    Комментарий удален автором.
                    <?php else: ?>
                    <?php if ($data->remove->type == 5): ?>
                        Комментарий удален владельцем страницы.
                        <?php else: ?>
                        <?php if ($data->remove->type != 4): ?>
                            Комментарий удален. Причина: <?php echo Removed::$types[$data->remove->type]; ?>
                            <?php else: ?>
                            Комментарий удален модератором.
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="comment-action">

    </div>
</li>