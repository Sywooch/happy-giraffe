<?php if (!Yii::app()->user->isGuest): ?>
<div class="actions">
    <?php
    if ($data->author_id != Yii::app()->user->id) {
        $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
        $report->button("$(this).parents('.item').find('.comment-action')");
        $this->endWidget();
    }
    ?>
    <?php if (Yii::app()->user->model->checkAuthItem('editComment') ||
            Yii::app()->user->model->checkAuthItem('removeComment') ||
            $data->isEntityAuthor(Yii::app()->user->id) ||
            Yii::app()->user->id == $data->author_id
): ?>
    <div class="admin-actions">
        <?php if ((Yii::app()->user->model->checkAuthItem('editComment') || Yii::app()->user->id == $data->author_id) && $data->isTextComment()): ?>
        <?php echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit', 'onclick' => 'return Comment.edit(this);')); ?>
        <?php endif; ?>
        <?php if ((Yii::app()->user->model->checkAuthItem('removeComment') || Yii::app()->user->id == $data->author_id) || $data->isEntityAuthor(Yii::app()->user->id)): ?>
        <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
            'model' => $data,
            'callback' => 'Comment.remove',
            'author' => Yii::app()->user->id == $data->author_id || $data->isEntityAuthor(Yii::app()->user->id)
        )); ?>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    <?php if($this->actions): ?>
    <a href="javascript:void(0);" onclick="return Comment.response(this);">Ответить</a>
    &nbsp;
    <a href="javascript:void(0);" class="quote-link" onclick="return Comment.quote(this);">С цитатой</a>
    <?php endif; ?>

</div>
<?php endif; ?>