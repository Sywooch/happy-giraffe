<li class="clearfix item" id="comment_<?php echo $data->id; ?>">
    <div class="clearfix">
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->author)); ?>
        </div>
        <div class="content">
            <div class="meta">
                <span class="num" id="cp_<?php echo $data->position; ?>"><?php echo $data->position; ?></span>
                <span class="date"><?php echo HDate::GetFormattedTime($data->created, ', '); ?></span>
                <?php if (($data->response_id !== null && $response = $data->response) || ($data->quote_id !== null && $response = $data->quote)): ?>
                <div class="answer">
                    Ответ для
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $response->author, 'sendButton' => false)); ?>
                    на <span class="num"><a href="#"
                                            onclick="return Comment.goTo(<?php echo $response->position; ?>, <?php echo $currentPage + 1; ?>);"><?php echo $response->position; ?></a></span>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($data->removed == 0): ?>
                <?php if (($data->quote_id !== null && $data->quote)): ?>
                    <input type="hidden" name="selectable_quote" value="<?php echo $data->quote_text != '' ? 1 : 0; ?>"/>
                    <div class="quote" id="commentQuote_<?php echo $data->quote->id; ?>">
                        <?php echo $data->quote_text != '' ? $data->quote_text : $data->quote->text; ?>
                    </div>
                <?php endif; ?>
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
                        <?php if (Yii::app()->user->checkAccess('editComment', array('user_id' => $data->author->id)) || Yii::app()->user->checkAccess('removeComment', array('user_id' => $data->author->id))): ?>
                        <div class="admin-actions">
                            <?php if (Yii::app()->user->checkAccess('editComment', array('user_id' => $data->author->id))): ?>
                            <?php echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit', 'onclick' => 'return Comment.edit(this);')); ?>
                            <?php endif; ?>
                            <?php if (Yii::app()->user->checkAccess('removeComment', array('user_id' => $data->author->id))): ?>
                            <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                                'model' => $data,
                                'callback' => 'Comment.remove',
                                'author' => !Yii::app()->user->isGuest && Yii::app()->user->id == $data->author->id
                            )); ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php if($this->actions): ?>
                            <a href="javascript:void(0);" onclick="return Comment.response(this);">Ответить</a>
                            &nbsp;
                            <a href="javascript:void(0);" onclick="return Comment.quote(this);">С цитатой</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="content-in">
                    <?php if ($data->remove->type == 0): ?>
                    Комментарий удален автором.
                    <?php else: ?>
                    <?php if ($data->remove->type != 4): ?>
                        Комментарий удален. Причина: <?php echo Removed::$types[$data->remove->type]; ?>
                        <?php else: ?>
                        Комментарий удален модератором.
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="comment-action">

    </div>
</li>