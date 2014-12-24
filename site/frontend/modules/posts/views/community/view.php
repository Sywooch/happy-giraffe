<?php
/** @todo перенести обработку $this->post->metaObject в контроллер */
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;
$this->breadcrumbs = array(
    '<span class="ava ava__small">' . CHtml::image($this->user->avatarUrl, $this->user->fullName, array('class' => 'ava_img')) . "</span>" => $this->user->profileUrl,
    'Блог' => Yii::app()->createUrl('/blog/default/index', array('user_id' => $this->user->id)),
    $this->post->title,
);
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
        /** @todo Исправить класс при конвертации */
        'entity' => 'BlogContent', //$this->post->originEntity,
        'entity_id' => $this->post->originEntityId,
        )));
$this->renderPartial('site.frontend.modules.posts.views.post._view');
?>
