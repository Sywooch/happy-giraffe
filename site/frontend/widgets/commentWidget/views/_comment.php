<li class="clearfix item" id="comment_<?php echo $data->id; ?>">
    <div class="user">
        <?php $this->widget('AvatarWidget', array('user' => $data->author, 'withMail' => false)); ?>
        <div class="details">
            <span class="icon-status status-<?php echo $data->author->online == 1 ? 'online' : 'offline'; ?>"></span>
            <a href="javascript:void(0);" class="username"><?php echo $data->author->fullName; ?></a>
            <?php if($data->author->country !== null): ?>
                <div class="location">
                    <div class="flag flag-<?php echo $data->author->country->iso_code; ?>"></div>
                    <?php echo $data->author->country->name; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="content">
        <div class="meta">
            <span class="num" id="cp_<?php echo $data->position; ?>"><?php echo $data->position; ?></span>
            <span class="date"><?php echo HDate::GetFormattedTime($data->created, ', '); ?></span>
            <?php if(($data->response_id !== 0 && $response = $data->response) || ($data->quote_id !== 0 && $response = $data->quote)): ?>
                <div class="answer">
                    Ответ для
                    <?php $this->widget('AvatarWidget', array('user' => $response->author, 'withMail' => false)); ?>
                    на <span class="num"><a href="#" onclick="return Comment.goTo(<?php echo $response->position; ?>, <?php echo $currentPage + 1; ?>);"><?php echo $response->position; ?></a></span>
                </div>
            <?php endif; ?>
        </div>
        <?php if(($data->quote_id !== 0 && $data->quote)): ?>
            <div class="quote">
                <?php echo $data->quote->text; ?>
            </div>
        <?php endif; ?>
        <?php if($data->removed == 0): ?>
            <div class="content-in">
                <?php echo $data->text; ?>
            </div>
            <?php if(!Yii::app()->user->isGuest): ?>
                <div class="actions">
                    <?php
                    if ($data->author->id != Yii::app()->user->id) {
                        $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
                        $report->button("$(this).parents('.content:eq(0)')");
                        $this->endWidget();
                    }
                    ?>
                    <?php if (Yii::app()->user->checkAccess('editComment',array('user_id'=>$data->author->id)) || Yii::app()->user->checkAccess('removeComment',array('user_id'=>$data->author->id))): ?>
                        <div class="admin-actions">
                            <?php if (Yii::app()->user->checkAccess('editComment',array('user_id'=>$data->author->id))): ?>
                                <?php echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit edit-comment')); ?>
                            <?php endif; ?>
                            <?php if (Yii::app()->user->checkAccess('removeComment',array('user_id'=>$data->author->id))): ?>
                                <?php echo CHtml::link('<i class="icon"></i>', '#', array(
                                    'class' => 'remove',
                                    'onclick' => 'return Comment.removeConfirm(this, ' . ($data->author->id == Yii::app()->user->id ? 'true' : 'false') . ');'
                                )); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <a href="#add_comment" onclick="return Comment.response(this);">Ответить</a>
                    &nbsp;
                    <a href="#add_comment" onclick="return Comment.quote(this);">С цитатой</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if($data->removed == 1): ?>
            <div class="content-in">
                <?php if($data->remove->type == 0): ?>
                    Комментарий удален автором.
                <?php else: ?>
                    Комментарий удален. Причина: <?php echo $data->remove->type == 4 ? $data->remove->text : Removed::$types[$data->remove->type]; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</li>