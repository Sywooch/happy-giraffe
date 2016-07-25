<?php
$cs = Yii::app()->clientScript;
if (Yii::app()->vm->version != VersionManager::VERSION_MOBILE) {
    $cs->registerAMD('photoAd', array('popup' => 'photo-ad/photo-popup'));
}
/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;

// Скопировано из site\frontend\modules\community\controllers\DefaultController::actionView
$this->breadcrumbs = array(
    'Жизнь' => array('/posts/buzz/list/index'),
    $this->post->title,
);

$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
    /** @todo Исправить класс при конвертации */
    'entity' => 'BlogContent', //$this->post->originEntity,
    'entity_id' => $this->post->originEntityId,
)));
?>
<?php $this->renderPartial('site.frontend.modules.posts.views.post._view'); ?>