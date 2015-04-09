<?php
Yii::app()->clientScript->registerAMD('BlogRecordSettings', array('kow'));
/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;
$this->breadcrumbs = array(
    'Утро с Весёлым жирафом' => '/morning/',
    $this->post->title,
);
?>

<?php
$this->renderPartial('site.frontend.modules.posts.views.post._view');
?>