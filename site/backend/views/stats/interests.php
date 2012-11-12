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