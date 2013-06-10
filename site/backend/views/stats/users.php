<h1>Пользователей с аватаром, интересами, статьями, местом нахождения, фотками </h1>
<?php
$result = 0;

$criteria = new CDbCriteria;
//$criteria->condition = 'avatar_id IS NOT NULL AND birthday IS NOT NULL
//    AND email_confirmed = 1 AND `group` = 0 AND relationship_status IS NOT NULL';
$criteria->condition = '`group` = 0 and deleted = 0 and last_active > :date';
$criteria->params = array(':date'=> date("Y-m-d H:i:s", strtotime('-2 month')));
//$criteria->with = array(
//    'address',
//    'communityContentsCount',
//    'photosCount',
//    'interests'
//);
$criteria->limit = 100;
$criteria->offset = 0;

$models = array(0);
while (!empty($models)) {
    $models = User::model()->findAll($criteria);

    foreach ($models as $model) {
            echo $model->fullName. ' - http://www.happy-giraffe.ru/user/'.$model->id.'/'."<br>";
            $result++;
    }

    $criteria->offset += 100;
}

echo $result.'<br>';
?>