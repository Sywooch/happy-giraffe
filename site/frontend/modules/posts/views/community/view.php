<?php

/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;

// Скопировано из site\frontend\modules\community\controllers\DefaultController::actionView
$this->breadcrumbs = array();
if($this->club) {
    $this->breadcrumbs[$this->club->title] = $this->club->getUrl();
} elseif($this->forum) {
    $this->breadcrumbs[$this->forum->title] = $this->forum->getUrl();
}
if (isset($this->club->communities) && count($this->club->communities) > 1) {
    $this->breadcrumbs[$this->forum->title] = $this->forum->getUrl();
}
$this->breadcrumbs[] = $this->post->title;
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
        /** @todo Исправить класс при конвертации */
        'entity' => 'BlogContent', //$this->post->originEntity,
        'entity_id' => $this->post->originEntityId,
        )));
$this->renderPartial('site.frontend.modules.posts.views.post._view');
?>
