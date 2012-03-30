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
        <?php if (Yii::app()->user->checkAccess('editComment', array('user_id' => $data->author->id)) && $data->isTextComment()): ?>
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