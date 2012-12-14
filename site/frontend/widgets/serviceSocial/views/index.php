<?php $this->render('_service_likes', array(
    'service' => $service,
    'image' => $image,
    'description' => $description
)); ?>
<div class="assistance clearfix">
    <?php $this->render('_assistance_users', compact('service')); ?>
    <?php $this->render('_assistance_count', array('count' => $service->using_count)); ?>
</div>
<?php if ($service->id == 9 && Yii::app()->user->checkAccess('services'))
    $this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $service));
elseif ($service->id != 9)
    $this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $service));
