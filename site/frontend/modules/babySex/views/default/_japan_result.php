<?php echo CHtml::link('previous month', '#', array('id'=>'japan-prev-month')) ?>
<table cellspacing="2" cellpadding="2" class="calendar-table">
    <tr>
        <th colspan="7"><?php echo  HDate::ruMonth($month).', '.$year ?></th>
    </tr>
    <tr>
        <th>Пн</th>
        <th>Вт</th>
        <th>Ср</th>
        <th>Чт</th>
        <th>Пт</th>
        <th>Сб</th>
        <th>Вс</th>
    </tr>
    <tr>
    <?php
//    var_dump($data);

    $i = 0;
    foreach ($data as $cell) {
        if ($i % 7 == 0 && $i != 0 && count($data) != $i)
            echo "</tr><tr>";
        $i++;
        echo $cell['cell'];
    }
    ?>
    </tr>
</table>
<?php echo CHtml::link('next month', '#', array('id'=>'japan-next-month')) ?>