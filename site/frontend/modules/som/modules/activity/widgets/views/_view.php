<?php

use site\frontend\modules\som\modules\activity\models\Activity;

/*@var $data Activity */

$user = $this->getUserInfo($data->userId);

$renderData = [
    'data' => $data,
    'user' => $user,
    'widget' => $this
];

if (!$this->ownerId)
{
    $template = 'site.frontend.modules.som.modules.activity.widgets.views.other';
    $this->controller->renderPartial($template, $renderData);
    return;
}

switch ($data->typeId) {
    case Activity::TYPE_ANSWER_PEDIATRICIAN:
    case Activity::TYPE_COMMENT:
        $answerModel = $data->getDataObject();

        if ($answerModel) {
            $renderData['data'] = $answerModel;
            $template = 'site.frontend.modules.som.modules.qa.views._new_answers';
        } else {
            $template = 'site.frontend.modules.som.modules.activity.widgets.views.other';
        }
        break;

    default:
        $template = 'site.frontend.modules.som.modules.activity.widgets.views.other';
        break;
}

$this->controller->renderPartial($template, $renderData);

?>