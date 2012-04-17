<?php
/* @var $this CController
 * @var $month int
 * @var $year int
 * @var $activeDate date
 */

$data = UserSignalHistory::getCalendarData($year, sprintf("%02d", $month));
?>
<table>
    <thead>
    <tr class="nav">
        <td colspan="7">
            <a href="" class="prev" onclick="Signal.LoadPrevMonth();return false;"></a>
            <a href="" class="next" onclick="Signal.LoadNextMonth();return false;"></a>

            <div class="date"><?php echo HDate::ruMonth($month) . ' ' . $year  ?></div>
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

    $skip = date("w", mktime(0, 0, 0, $month, 1, $year)) - 1; // узнаем номер дня недели
    if ($skip < 0) {
        $skip = 6;
    }
    $daysInMonth = date("t", mktime(0, 0, 0, $month, 1, $year)); // узнаем число дней в месяце
    $day = 1;       // для цикла далее будем увеличивать значение

    for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

        echo '<tr>'; // открываем тэг строки
        for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

            if (($skip > 0)or($day > $daysInMonth)) { // выводим пустые ячейки до 1 го дня ип после полного количства дней

                echo '<td class="none"> </td>';
                $skip--;
            }
            else {
                if ($year . '-' . sprintf("%02d", $month) . '-' . sprintf("%02d", $day) == $activeDate) {
                    echo '<td class="active"><a>' . $day . '</a></td>';
                }
                else {
                    if (isset($data[$day]))
                        echo '<td>' . $data[$day] . '</td>';
                    else
                        echo '<td>' . $day . '</td>';
                }
                $day++; // увеличиваем $day
            }

        }
        echo '</tr>'; // закрываем тэг строки
    }
    ?>
    </tbody>
</table>
