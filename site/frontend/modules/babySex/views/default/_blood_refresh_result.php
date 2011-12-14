<?php
/* @var $model BloodRefreshForm
 * @var $form CActiveForm
 */
?>
<div class="mother_calendar">
    <div class="choice_month">
        <a href="#" class="l_arr_mth_active" id="blood-refresh-prev-month">&larr;</a>
        <a href="#" class="r_arr_mth_active" id="blood-refresh-next-month">&rarr;</a>
        <span><?php echo  HDate::ruMonth($month) . ', ' . $year ?></span>
    </div>
    <!-- .choice_month -->
    <table class="calendar_body">
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
            $i = 0;
            foreach ($data as $cell) {
                if ($i % 7 == 0 && $i != 0 && count($data) != $i)
                    echo "</tr><tr>";
                $i++;?>
                <td>
                    <?php if ($cell['other_month']): ?>

                    <?php if ($cell['sex'] == BloodRefreshForm::IS_BOY)
                        $class = 'boy_cl';
                    elseif ($cell['sex'] == BloodRefreshForm::IS_GIRL)
                        $class = 'girl_cl';
                    else
                        $class = '';?>
                    <div class="cal_item_default">
                        <div
                            class="cal_item <?php echo $class ?>" <?php echo 'style="opacity:' . $cell['opacity'] . '"' ?>>
                            <ins><?php echo $cell['day'] ?></ins>
                        </div>
                        <?php if ($cell['probability'] > 0): ?>
                        <div class="hint" style="display: none;">
                            <?php echo $cell['probability'] ?> %
                        </div>
                        <?php endif ?>
                    </div>

                    <?php else: ?>

                    <?php
                    $baby = '';
                    if ($cell['sex'] == BloodRefreshForm::IS_BOY)
                        $baby = '<div class="boy_lvl5" style="opacity:' . $cell['opacity'] . '"></div>';
                    elseif ($cell['sex'] == BloodRefreshForm::IS_GIRL)
                        $baby = '<div class="girl_lvl5" style="opacity:' . $cell['opacity'] . '"></div>';
                    ?>
                    <div class="cal_item<?php if ($cell['day'] == $model->baby_d
                        && !$cell['other_month'] && $month == $model->baby_m && $year == $model->baby_y
                    ) echo ' active_item' ?>">
                        <?php echo $baby ?>
                        <ins><?php echo $cell['day'] ?></ins>
                        <?php if ($cell['probability'] > 0): ?>
                        <div class="hint" style="display: none;">
                            <?php echo $cell['probability'] ?> %
                        </div>
                        <?php endif ?>
                    </div>

                    <?php endif ?>
                </td>
                <?php } ?>
        </tr>
    </table>
</div><!-- .mother_calendar -->
<?php if ($gender == BloodRefreshForm::IS_GIRL): ?>
<div class="wh_wait wh_daughter">
    <span class="title_wh_wait">Поздравляем! У вас будет девочка!</span>

    <p>Это значит, что кровь мамы на момент зачатия оказалась «моложе» крови папы. Кровь женщины обновляется раз в три
        года, а мужчины – раз в четыре. Однако это может случиться и внепланово, при массивной кровопотере
        (хирургические операции, донорство, роды, переливание крови, аборт). Менструальные кровотечения не учитываются.
        Метод имеет точность чуть более 50%, поэтому гарантии рождения девочки не даёт.</p>
</div><!-- .wh_wait -->
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_BOY): ?>
<div class="wh_wait wh_son">
    <span class="title_wh_wait">Поздравляем! У вас будет мальчик!</span>

    <p>Это значит, что на момент зачатия кровь папы оказалась более «молодой». Считается, что кровь мужчины обновляется
        каждые 4 года, а у женщины – каждые три. Обновление крови происходит при каждой массивной кровопотере (роды,
        аборт, хирургическая операция, переливание крови или сдача крови донором). Точность метода всего 52% , поэтому
        гарантии рождения мальчика не даёт.</p>
</div><!-- .wh_wait -->
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_UNKNOWN): ?>
<div class="wh_wait">
    <p><b>Мальчик или девочка?</b> У мамы и папы кровь обновилась примерно в одно время. Поэтому точно вычислить пол будущего ребёнка не получилось. Попробуйте воспользоваться другими методами и определить, кто у вас родится – мальчик или девочка.</p>
</div><!-- .wh_wait -->
<?php endif ?>
