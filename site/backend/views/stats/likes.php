<?php

Yii::import('site.frontend.modules.contest.models.*');
$models = Rating::model()->findAllByAttributes(array('entity_name' => 'ContestWork'));
echo count($models) . ' участников<br><br>';

$likes = array('tw' => 0, 'vk' => 0, 'ok' => 0, 'fb' => 0, 'yh' => 0);
foreach ($models as $model) {
    $entity = ContestWork::model()->findByPk($model->entity_id);
    if ($entity !== null && $entity->contest_id == 2)
        foreach ($likes as $social_key => $like)
            if (isset($model->ratings[$social_key]))
                $likes[$social_key] += $model->ratings[$social_key];
}

echo 'Facebook: ' . $likes['fb'] . '<br>';
echo 'Вконтакте: ' . $likes['vk'] . '<br>';
echo 'Одноклассники: ' . $likes['ok'] . '<br>';
echo 'Twitter: ' . $likes['tw'] . '<br>';
echo 'Yohoho: ' . ($likes['yh'] / 2) . '<br>';