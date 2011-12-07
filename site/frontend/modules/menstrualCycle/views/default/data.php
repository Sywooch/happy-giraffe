<?php
$month = date("m"); //1-12
$year = date("Y");

for ($month_iter = 0; $month_iter < 2; $month_iter++) {

    $skip = date("w", mktime(0, 0, 0, $month, 1, $year)) - 1; // узнаем номер дня недели
    if ($skip < 0)
        $skip = 6;

    $daysInMonth = date("t", mktime(0, 0, 0, $month, 1, $year)); // узнаем число дней в месяце
    $calendar_head = ''; // обнуляем calendar head
    $calendar_body = ''; // обнуляем calendar boday
    $day = 1; // для цикла далее будем увеличивать значение

    for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

        $calendar_body .= '<tr>'; // открываем тэг строки
        for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

            if (($skip > 0)or($day > $daysInMonth)) { // выводим пустые ячейки до 1 го дня ип после полного количства дней

                $calendar_body .= '<td class="none"> </td>';
                $skip--;

            }
            else {
                $datetime = strtotime($day.'-'.$month.'-'.$year);
                if (isset($data[$datetime]))
                    $calendar_body .= '<td class="'.$data[$datetime].'">' . $day . '</td>';
                else
                    $calendar_body .= '<td>' . $day . '</td>';
                $day++; // увеличиваем $day
            }

        }
        $calendar_body .= '</tr>'; // закрываем тэг строки
        if ($day > $daysInMonth)
            break;
    }

    // заголовок календаря
    $calendar_head = '
  <tr>
        <th colspan="7">' . HDate::ruMonth($month).', '.$year . '</th>
  </tr>
  <tr>
    <th>Пн</th>
    <th>Вт</th>
    <th>Ср</th>
    <th>Чт</th>
    <th>Пт</th>
    <th>Сб</th>
    <th>Вс</th>
  </tr>';

    ?>
<table <?php echo ($month_iter == 0)?'id="main-calendar"':'' ?> cellspacing="2" cellpadding="2" class="calendar-table">
    <thead>
        <?php echo $calendar_head; ?>
    </thead>
    <tbody>
        <?php echo $calendar_body; ?>
    </tbody>
</table><br><br>
<?php
    $month++;
    if ($month == 13){
        $month = 1;
        $year++;
    }
} ?>