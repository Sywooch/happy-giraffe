<?php
/**
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var CommunityContent $content кол-во подписчиков
 */
Yii::app()->clientScript->useAMD = true;

$this->renderPartial('blog.views.default.view_requirejs', array('full' => true, 'data' => $content));
?>