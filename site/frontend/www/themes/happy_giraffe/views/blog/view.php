<?php $this->renderPartial('/community/_post', array('data' => $data, 'full' => true)); ?>

<div class="content-more clearfix">
    <big class="title">
        Другие записи моего блога
        <a href="<?php echo $this->createUrl('/blog/list', array('user_id' => $this->user->id)); ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
    </big>
    <?php foreach ($data->relatedPosts as $rc): ?>
            <div class="block">
                <b><?php echo CHtml::link($rc->title, $this->createUrl('/blog/view', array('content_id' => $rc->id))); ?></b>
                <p><?php echo $rc->short; ?></p>
            </div>
    <?php endforeach; ?>
</div>

<?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
    'model' => $data,
)); ?>

<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>