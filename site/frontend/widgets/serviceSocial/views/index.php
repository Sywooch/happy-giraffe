<?php
if (isset($_GET['Comment_page']))
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

//$this->render('_service_likes', array(
//    'service' => $service,
//    'image' => $image,
//    'description' => $description
//));
?>
<div class="col-white">
    <div class="assistance clearfix">
        <?php $this->render('_assistance_users', array('service' => $service, 'count' => $service->using_count)); ?>
        <?php $this->render('_assistance_count', array('count' => $service->using_count)); ?>
    </div>
</div>
<?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $service));
