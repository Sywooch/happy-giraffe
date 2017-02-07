<?php

use site\frontend\modules\som\modules\activity\models\Activity;

$user = $this->getUserInfo($data->userId);

if (! $this->ownerId)
{
    $renderData = [
        'data'          => $data,
        'user'          => $user,
        'widget'        => $this
    ];

    $template = 'site.frontend.modules.som.modules.activity.widgets.views.other';
}
else
{
    switch ($data->typeId) {
        case Activity::TYPE_ANSWER_PEDIATRICIAN:
        case Activity::TYPE_COMMENT:
            $answerModel = @unserialize($data->data);

            if ($answerModel) {
                $renderData = [
                    'data' => $answerModel
                ];

                $template = 'site.frontend.modules.som.modules.qa.views._new_answers';
            } else {
                $renderData = [
                    'data' => $data,
                    'user' => $user,
                    'widget' => $this
                ];

                $template = 'site.frontend.modules.som.modules.activity.widgets.views.other';
            }
            break;

        default:
            $renderData = [
                'data' => $data,
                'user' => $user,
                'widget' => $this
            ];

            $template = 'site.frontend.modules.som.modules.activity.widgets.views.other';
            break;
    }
}

$this->controller->renderPartial($template, $renderData);

?>