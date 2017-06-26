<?php

use site\frontend\modules\iframe\models\QaAnswer;
use site\frontend\modules\iframe\components\QaObjectList;
use site\frontend\modules\iframe\models\QaAnswerVote;

/*@var $data QaAnswer */

$user = $this->getUserInfo($data->authorId);

$renderData = [
    'data' => $data,
    'user' => $user,
    'widget' => $this
];

$currentUser = \Yii::app()->user;
$renderData['data'] = $data;

if (!$currentUser->isGuest)
{
    $renderData['additionalData']['votesList'] = new QaObjectList(QaAnswerVote::model()->user($currentUser->id)->findAll());
}

$template = 'site.frontend.modules.iframe.views._new_answers';

$this->controller->renderPartial($template, $renderData);

?>
