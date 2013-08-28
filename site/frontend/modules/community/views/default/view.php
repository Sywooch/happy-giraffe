<?php
/**
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var CommunityContent $content кол-во подписчиков
 */

$this->renderPartial('blog.views.default.view', array('full' => true, 'data' => $content));


