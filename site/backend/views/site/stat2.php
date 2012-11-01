<?php
Yii::import('site.frontend.modules.geo.models.*');
//по регионам
$criteria = new CDbCriteria;
$criteria->limit = 100;
$criteria->offset = 0;
$criteria->with = array('userAddress');

$models = array(0);
$result = array();
while (!empty($models)) {
    $models = User::model()->findAll($criteria);

    foreach ($models as $model) {
        if (isset($model->userAddress->region_id)) {
            if (isset($result[$model->userAddress->region_id]))
                $result[$model->userAddress->region_id]++;
            else
                $result[$model->userAddress->region_id] = 1;
        }
    }

    $criteria->offset += 100;
}

arsort($result);

foreach ($result as $result_id=>$count)
    echo GeoRegion::model()->findByPk($result_id)->name . ' : ' . $count . '<br>';
?>
<h1>Interests</h1>
<?php
$result = array();
$categories = InterestCategory::model()->findAll(array(
    'with' => array(
        'interests' => array(
            'with' => 'usersCount',
        ),
    ),
));
foreach ($categories as $category)
    foreach ($category->interests as $interest)
        $result[$interest->title] = $interest->usersCount;

arsort($result);
foreach ($result as $result_id => $count)
    echo $result_id . ' : ' . $count . '<br>';
?>
<h1>Сколько сегодня зашло зарегистрированных пользователей</h1>
<?php
$today = date("Y-m-d") . ' 00:00:00';
echo User::model()->count('last_active >= "' . $today . '"') . '<br>';
?>
<h1>всех сотрудников проверить на заполненность профиля</h1>
<?php
$result = 0;

$criteria = new CDbCriteria;
$criteria->condition = '`group` != 0 AND `group` != '.UserGroup::VIRTUAL;
$criteria->with = array(
    'communitiesCount',
    'userAddress',
    'photosCount',
    'interests',
    'status',
    'purpose'
);
$criteria = new CDbCriteria;
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

?>
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
$criteria = new CDbCriteria;
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
<h1>Пользовательский контент</h1>
<?php
$criteria = new CDbCriteria;
$criteria->condition = 'uniqueness > 50 AND created > "2012-10-01 00:00:00" AND
created < "2012-11-01 00:00:00" AND `author`.`group` = 0';
$criteria->with = array('author');
echo CommunityContent::model()->count($criteria);
?>