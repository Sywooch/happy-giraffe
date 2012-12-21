<?php
if (isset($_GET['Comment_page']))
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

$this->render('_service_likes', array(
    'service' => $service,
    'image' => $image,
    'description' => $description
)); ?>
<div class="assistance clearfix">
    <?php $this->render('_assistance_users', compact('service')); ?>
    <?php $this->render('_assistance_count', array('count' => $service->using_count)); ?>
</div>
<?php $this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $service));
