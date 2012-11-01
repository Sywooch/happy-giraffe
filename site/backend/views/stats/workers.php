<h1>всех сотрудников проверить на заполненность профиля</h1>
<?php
$result = 0;

$criteria = new CDbCriteria;
$criteria->condition = '`group` != 0 AND `group` != '.UserGroup::VIRTUAL;
$criteria->order = 'id';
$criteria->with = array(
    'communitiesCount',
    'userAddress',
    'photosCount',
    'interests',
    'status',
    'purpose'
);
$criteria->limit = 100;
$criteria->offset = 0;

$models = array(0);
while (!empty($models)) {
    $models = User::model()->findAll($criteria);

    foreach ($models as $model) {
        $user_title = CHtml::link($model->fullName, 'http://www.happy-giraffe.ru/user/'.$model->id.'/');

        if (empty($model->avatar_id))
            echo $user_title.' - загрузить аватар<br>';
        if (empty($model->birthday))
            echo $user_title.' - установить дату рождения<br>';
        if (empty($model->email_confirmed))
            echo $user_title.' - подтвердить email<br>';
        if (empty($model->userAddress->country_id))
            echo $user_title.' - заполнить место жительства<br>';
        if (empty($model->relationship_status))
            echo $user_title.' - заполнить информацию о семье<br>';
        if (!isset($model->status->text) && empty($model->status->text))
            echo $user_title.' - установить статус<br>';
        if (!isset($model->purpose->text) && empty($model->purpose->text))
            echo $user_title.' - установить цель<br>';

        if ($model->communitiesCount < 9)
            echo $user_title.' - вступить в сообщества<br>';
        if ($model->photosCount < 2)
            echo $user_title.' - выложить фото<br>';
    }

    $criteria->offset += 100;
}
