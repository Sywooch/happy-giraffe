<div class="actions">
    <?php if (!Yii::app()->user->isGuest): ?>
        <?php
        if ($data->author_id != Yii::app()->user->id) {
            $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
            $report->button("$(this).parents('.item').find('.comment-action')");
            $this->endWidget();
        }
        
        if (Yii::app()->user->model->checkAuthItem('editComment') ||
                    Yii::app()->user->model->checkAuthItem('removeComment') ||
                    $data->isEntityAuthor(Yii::app()->user->id) ||
                    Yii::app()->user->id == $data->author_id
        ): ?>
        <div class="admin-actions">
            <?php if ((Yii::app()->user->model->checkAuthItem('editComment') || Yii::app()->user->id == $data->author_id) && $data->isTextComment()): ?>
            <?= CHtml::link('<i class="icon"></i>', '', array('class' => 'edit', 'onclick' => 'return '.$this->objectName.'.edit(this);')); ?>
            <?php endif; ?>
            <?php if ((Yii::app()->user->model->checkAuthItem('removeComment') || Yii::app()->user->id == $data->author_id) || $data->isEntityAuthor(Yii::app()->user->id))
            $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                'model' => $data,
                'callback' => 'function() {'.$this->objectName.'.remove();}',
                'author' => Yii::app()->user->id == $data->author_id || $data->isEntityAuthor(Yii::app()->user->id)
            )); ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php if($this->actions): ?>
        <?php if (Yii::app()->user->isGuest):?>
            <a id="c_ans_<?=$data->id ?>" href="javascript:;" onclick="showLoginWindow();setRedirectUrl('c_ans_<?=$data->id ?>');">Ответить</a>
            &nbsp;
            <a id="c_ans_q_<?=$data->id ?>" href="javascript:;" class="quote-link" onclick="showLoginWindow();setRedirectUrl('c_ans_q_<?=$data->id ?>');">С цитатой</a>
        <?php else: ?>
            <a id="c_ans_<?=$data->id ?>" href="javascript:;" onclick="return <?= $this->objectName; ?>.response(this);">Ответить</a>
            &nbsp;
            <a id="c_ans_q_<?=$data->id ?>" href="javascript:;" class="quote-link" onclick="return <?= $this->objectName; ?>.quote(this);">С цитатой</a>
        <?php endif ?>
    <?php endif; ?>

</div>