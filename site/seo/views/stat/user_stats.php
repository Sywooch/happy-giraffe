<?php
/**
 * @var $last_date string
 * @var $days int
 * @var $user_id int
 */
?>
<?=CHtml::link('неделя', $this->createUrl('stat/userStats', array('user_id'=>$user_id))) ?><br>
<?=CHtml::link('месяц', $this->createUrl('stat/userStats', array('user_id'=>$user_id, 'last_date'=>date("Y-m-d"), 'date'=>date("Y-m-d", strtotime('-1 month'))  ))) ?>
<?php $this->renderPartial('_date_form', compact('user_id')); ?>
<table>
    <thead>
    <tr>
        <th>дата</th>
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
        $stats->user_id = $user_id;

        echo '<td>'.$date.'</td>';
        $this->renderPartial('_table_row',compact('stats'));

        echo '</tr>';
    }?>
    </tbody>
</table>
