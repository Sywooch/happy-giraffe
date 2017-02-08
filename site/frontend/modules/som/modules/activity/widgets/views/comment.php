<?php

use site\frontend\modules\som\modules\activity\models\Activity;

/*@var $data Activity */

$model = $data->getDataObject();

if (is_null($model))
{
    $renderData = [
        'data'      => $data,
        'user'      => $user,
        'widget'    => $widget
    ];
    $template = 'site.frontend.modules.som.modules.activity.widgets.views.comment_json';
}
else
{
    $renderData = [
        'data'      => $model,
        'user'      => $user,
        'widget'    => $widget
    ];
    $template = 'site.frontend.modules.som.modules.activity.widgets.views.comment_object';
}

$this->controller->renderPartial($template, $renderData);