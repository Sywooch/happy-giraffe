<div class="fast-calendar">
    <table>
        <thead>
        <tr class="nav">
            <td colspan="7">
                <a href="" class="prev"></a>
                <a href="" class="next"></a>

                <div class="date">МАРТ 2012</div>
            </td>
        </tr>
        <tr>
            <th>пн</th>
            <th>вт</th>
            <th>ср</th>
            <th>чт</th>
            <th>пт</th>
            <th>сб</th>
            <th>вс</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //текущие месяц и год
        $month = date("m", mktime(0,0,0,date('m'),1,date('Y')));
        $year  = date("Y", mktime(0,0,0,date('m'),1,date('Y')));

        $skip = date("w", mktime(0, 0, 0, $month, 1, $year)) - 1; // узнаем номер дня недели
        if ($skip < 0) {
            $skip = 6;
        }
        $daysInMonth = date("t", mktime(0, 0, 0, $month, 1, $year));       // узнаем число дней в месяце
        $calendar_head = '';    // обнуляем calendar head
        $calendar_body = '';    // обнуляем calendar boday
        $day = 1;       // для цикла далее будем увеличивать значение

        for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

            $calendar_body .= '<tr>'; // открываем тэг строки
            for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

                if (($skip > 0)or($day > $daysInMonth)) { // выводим пустые ячейки до 1 го дня ип после полного количства дней

                    $calendar_body .= '<td class="none"> </td>';
                    $skip--;

                }
                else {

                    if ($j == 0) // если воскресенье то омечаем выходной
                        $calendar_body .= '<td class="holiday">' . $day . '</td>';
                    else { // в противном случае просто выводим день в ячейке
                        if ((date(j) == $day) && (date(m) == $month) && (date(Y) == $year)) { //проверяем на текущий день
                            $calendar_body .= '<td class="today">' . $day . '</td>';
                        }
                        else {
                            $calendar_body .= '<td class="day">' . $day . '</td>';
                        }
                    }
                    $day++; // увеличиваем $day
                }

            }
            $calendar_body .= '</tr>'; // закрываем тэг строки
        }
        ?>
        </tbody>
    </table>
</div>
