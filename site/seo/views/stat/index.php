<?php
/**
 * @var $last_date string
 * @var $days int
 */
?>

<table>
    <thead>
    <tr>
        <th>дата</th>
        <th>пользователе</th>
        <th>клубы - посты</th>
        <th>клубы - видео</th>
        <th>клубы - комменты</th>
        <th>блоги - посты</th>
        <th>блоги - видео</th>
        <th>блоги - комменты</th>
        <th>сервисы - посты</th>
        <th>сервисы - комменты</th>
        <th>гостевая</th>
        <th>фото - личн</th>
        <th>фото - сервисы</th>
        <th>переписка</th>
        <th>связей</th>
    </tr>
    </thead>
    <tbody>

    <?php
    for ($i = 0; $i < $days; $i++) {
        echo '<tr>';
        $date = date("Y-m-d", strtotime(' - ' . $i . ' days', strtotime($last_date)));
        $data = array();

        $stats = new UserStats;
        $stats->date = $date;
        $stats->group = UserGourp::USER;

        echo '<td>'.$date.'</td>';
        echo '<td>'.$stats->regCount($date).'</td>';
        echo '<td>'.$stats->clubPostCount().'</td>';
        echo '<td>'.$stats->clubVideoCount().'</td>';
        echo '<td>'.$stats->clubCommentsCount().'</td>';

        echo '<td>'.$stats->blogPostCount().'</td>';
        echo '<td>'.$stats->blogVideoCount().'</td>';
        echo '<td>'.$stats->blogCommentsCount().'</td>';

        echo '<td>'.$stats->servicePostCount().'</td>';
        echo '<td>'.$stats->serviceCommentsCount().'</td>';

        echo '<td>'.$stats->guestBookCommentsCount().'</td>';

        echo '<td>'.$stats->personalPhotoCount().'</td>';
        echo '<td>'.$stats->servicesPhotoCount().'</td>';

        echo '<td>'.$stats->messagesCount().'</td>';
        echo '<td>'.$stats->friendsCount().'</td>';

        echo '</tr>';
//    $data['new_users'] = Yii::app()->db->createCommand('select count(id) from community__contents
//    left join users ON users.id = community__contents.author_id
//    where created >= "' . $date . ' 00:00:00" AND created <= "' . $date . ' 23:59:59" AND type_id = 1')->queryScalar();
    }?>
    </tbody>
</table>
