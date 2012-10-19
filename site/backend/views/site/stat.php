<?php
echo 'Статей в клубах: ' . CommunityContent::model()->with(array('rubric' => array(
    'condition' => 'rubric.user_id IS NULL'
)))->count('removed = 0') . '<br>';
echo 'Статей в блогах: ' . CommunityContent::model()->with(array('rubric' => array(
    'condition' => 'rubric.user_id IS NOT NULL'
)))->count('removed = 0') . '<br>';

echo 'Статей: ' . CommunityContent::model()->count('type_id = 1 AND removed = 0') . '<br>';
echo 'Видео: ' . CommunityContent::model()->count('type_id = 2 AND removed = 0') . '<br>';
echo 'Утро с Веселым Жирафом: ' . CommunityContent::model()->count('type_id = 4 AND removed = 0') . '<br>';
echo 'Путешествий: ' . CommunityContent::model()->count('type_id = 3 AND removed = 0') . '<br>';
echo 'Имен: ' . Name::model()->count() . '<br>';
echo 'Рецептов: ' . RecipeBookRecipe::model()->count() . '<br>';
echo 'Болезней: ' . RecipeBookDisease::model()->count() . '<br><br><br>';


$models = Rating::model()->findAllByAttributes(array('entity_name' => 'ContestWork'));
echo count($models).'<br>';

$likes = array('tw' => 0, 'vk' => 0, 'ok' => 0, 'fb' => 0, 'yh' => 0);
foreach ($models as $model) {
    foreach ($likes as $social_key => $like)
        if (isset($model->ratings[$social_key]))
            $likes[$social_key] += $model->ratings[$social_key];
}

echo 'Facebook: ' . $likes['fb'] . '<br>';
echo 'Вконтакте: ' . $likes['vk'] . '<br>';
echo 'Одноклассники: ' . $likes['ok'] . '<br>';
echo 'Twitter: ' . $likes['tw'] . '<br>';
echo 'Yohoho: ' . ($likes['yh']/2) . '<br>';