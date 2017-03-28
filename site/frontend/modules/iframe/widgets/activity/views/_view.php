<?php

use site\frontend\modules\iframe\models\Activity;
use site\frontend\modules\iframe\components\QaObjectList;
use site\frontend\modules\iframe\models\QaAnswerVote;

/*@var $data Activity */

$user = $this->getUserInfo($data->userId);

$renderData = [
    'data' => $data,
    'user' => $user,
    'widget' => $this
];

if (!$this->ownerId)
{
    $template = 'site.frontend.modules.iframe.widgets.activity.views.other';
    $this->controller->renderPartial($template, $renderData);
    return;
}

switch ($data->typeId) {
    case Activity::TYPE_ANSWER_PEDIATRICIAN:
    case Activity::TYPE_COMMENT:
        $answerModel = $data->getDataObject();

        if ($answerModel) {

            $currentUser = \Yii::app()->user;
            $renderData['data'] = $answerModel;

            if (!$currentUser->isGuest)
            {
                $renderData['additionalData']['votesList'] = new QaObjectList(QaAnswerVote::model()->user($currentUser->id)->findAll());
            }

            $template = 'site.frontend.modules.iframe.views._new_answers';
        } else {
            $template = 'site.frontend.modules.iframe.widgets.activity.views.other';
        }
        break;

    default:
        $template = 'site.frontend.modules.iframe.widgets.activity.views.other';
        break;
}
$this->controller->renderPartial($template, $renderData);

?>