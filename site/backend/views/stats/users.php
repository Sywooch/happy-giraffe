<h1>Пользователей с аватаром, интересами, статьями, местом нахождения, фотками </h1>
<?php
$result = 0;

$criteria = new CDbCriteria;
$criteria->condition = 'avatar_id IS NOT NULL AND birthday IS NOT NULL
    AND email_confirmed = 1 AND `group` = 0 AND relationship_status IS NOT NULL';
$criteria->with = array(
    'userAddress',
    'communityContentsCount',
    'photosCount',
    'interests'
);
$criteria->limit = 100;
$criteria->offset = 0;

$models = array(0);
while (!empty($models)) {
    $models = User::model()->findAll($criteria);

    foreach ($models as $model) {
        if (!empty($model->userAddress->country_id)
            && $model->communityContentsCount > 0
            && $model->photosCount > 1
            && count($model->interests) > 0
        ){
            echo  CHtml::link($model->fullName, 'http://www.happy-giraffe.ru/user/'.$model->id.'/')."<br>";
            $result++;
        }
    }

    $criteria->offset += 100;
}

echo $result.'<br>';
?>