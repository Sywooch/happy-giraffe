<?php
/**
 * @var $last_date string
 * @var $date string
 * @var $user_id int
 */
echo CHtml::link('неделя', $this->createUrl('stat/userStats')) .'<br>';
echo CHtml::link('месяц', $this->createUrl('stat/userStats', array('last_date'=>date("Y-m-d"), 'date'=>date("Y-m-d", strtotime('-1 month'))))) .'<br>';
$this->renderPartial('_date_form', compact('user_id'));
?>
<table>
    <thead>
    <tr>
        <th>группа</th>
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
    for ($i = 0; $i <= 5; $i++) {
        echo '<tr>';
        $stats = new UserStats;
        $stats->date = $last_date;
        $stats->date2 = $date;
        $stats->group = $i;

        echo '<td>'.UserGourp::getName($i).'</td>';
        $this->renderPartial('_table_row',compact('stats'));

        echo '</tr>';
    }?>
    </tbody>
</table>
