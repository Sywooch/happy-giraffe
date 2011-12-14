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
    <span class="title_wh_wait">У Вас будет дочь</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил
        постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно.</p>
</div><!-- .wh_wait -->
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_BOY): ?>
<div class="wh_wait wh_daughter">
    <span class="title_wh_wait">У Вас будет сын</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил
        постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно.</p>
</div><!-- .wh_wait -->
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_UNKNOWN): ?>
<div class="wh_wait wh_daughter">
    <span class="title_wh_wait">Неизвестно</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил
        постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно.</p>
</div><!-- .wh_wait -->
<?php endif ?>
