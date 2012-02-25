<div class="comments">
    <div class="c-header">
        <div class="left-s">
            <span>Комментарии</span>
            <span class="col"><?php echo $total; ?></span>
        </div>
        <div class="right-s">
            <!--<b><a href="">Подписаться</a></b>-->
            <a class="btn btn-orange" href="#add_comment"><span><span>Добавить комментарий</span></span></a>
        </div>
        <div class="clear"></div>
    </div>
    <?php if ($comments): ?>
    <?php foreach ($comments as $cm): ?>
        <div class="item" id="CommunityComment_<?php echo $cm->id; ?>">
            <div class="clearfix">
                <div class="user">
                    <?php $this->widget('AvatarWidget', array('user' => $cm->author)); ?>
                    <a class="username"><?php echo $cm->author->first_name; ?></a>
                </div>
                <div class="text">
                    <div class="comment-content"><?php echo $cm->text; ?></div>

                    <div class="data">
                        <?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $cm->created); ?>
                        <?php
                        if ($cm->author->id != Yii::app()->user->id) {
                            $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $cm));
                            $report->button("$(this).parents('.item')");
                            $this->endWidget();
                        }
                        ?>
                    </div>
                    <?php if ($cm->author->id == Yii::app()->user->id || Yii::app()->authManager->checkAccess('edit comment',Yii::app()->user->getId())): ?>
                    <?php echo CHtml::link('редактировать', '#', array('class' => 'edit-comment')); ?>
                    <?php endif; ?>
                    <?php if ($cm->author->id == Yii::app()->user->id || Yii::app()->authManager->checkAccess('delete comment', Yii::app()->user->getId())): ?>
                    <?php echo CHtml::link('удалить', Yii::app()->createUrl('#', array('id' => $cm->id)), array(
                        'class' => 'remove-comment',
                    )); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>