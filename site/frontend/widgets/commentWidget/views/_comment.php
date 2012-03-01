<li class="clearfix" id="comment_<?php echo $data->position; ?>">
    <div class="user">
        <?php $this->widget('AvatarWidget', array('user' => $data->author, 'withMail' => false)); ?>
        <div class="details">
            <span class="icon-status status-<?php echo $data->author->online == 1 ? 'online' : 'offline'; ?>"></span>
            <a href="javascript:void(0);"><?php echo $data->author->fullName; ?></a>
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
            <span class="num"><?php echo $data->position; ?></span>
            <span class="date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $data->created); ?></span>
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
        <div class="content-in">
            <?php echo $data->text; ?>
        </div>
        <div class="actions">
            <?php
            if ($data->author->id != Yii::app()->user->id) {
                $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
                $report->button("$(this).parents('.content:eq(0)')");
                $this->endWidget();
            }
            ?>
            <?php if (($data->author->id == Yii::app()->user->id || Yii::app()->authManager->checkAccess('edit comment',Yii::app()->user->getId())) || ($data->author->id == Yii::app()->user->id || Yii::app()->authManager->checkAccess('delete comment', Yii::app()->user->getId()))): ?>
                <div class="admin-actions">
                    <?php if ($data->author->id == Yii::app()->user->id || Yii::app()->authManager->checkAccess('edit comment',Yii::app()->user->getId())): ?>
                        <?php echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit')); ?>
                    <?php endif; ?>
                    <?php if ($data->author->id == Yii::app()->user->id || Yii::app()->authManager->checkAccess('delete comment', Yii::app()->user->getId())): ?>
                        <?php echo CHtml::link('<i class="icon"></i>', Yii::app()->createUrl('#', array('id' => $data->id)), array(
                            'class' => 'remove',
                        )); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <a href="javascript:void(0)" onclick="return Comment.response(this);">Ответить</a>
            &nbsp;
            <a href="javascript:void(0)" onclick="return Comment.quote(this);">С цитатой</a>
        </div>
    </div>
</li>