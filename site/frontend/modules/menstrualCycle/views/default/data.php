<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model MenstrualCycleForm
 * @var $data array
 */
?>
<div class="mother_calendar">
    <div class="choice_month">
        <a href="#"
           class="l_arr_mth<?php if ($model->review_month != date('m') || $model->review_year != date('Y')) echo '_active' ?>"
           id="prev-month">&larr;</a>
        <a href="#" class="r_arr_mth_active" id="next-month">&rarr;</a>
        <span><?php echo HDate::ruMonth($model->review_month) ?>, <?php echo $model->review_year ?></span>
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
            <?php $i = 0;
            foreach ($data as $cell): ?>
                <?php if ($i % 7 == 0 && $i != 0 && count($data) != $i)
                    echo "</tr><tr>";
                $i++;?>
                <td>
                    <?php if ($cell['other_month']): ?>
                    <div class="cal_item_default">
                        <div class="cal_item <?php echo $cell['cell'] ?>">
                            <ins><?php echo $cell['day'] ?></ins>
                            <?php if ($cell['cell'] != '') : ?>
                            <div class="hint" style="display: none;">
                                <?php
                                switch ($cell['cell']) {
                                    case 'mens':
                                        echo 'менструация';
                                        break;
                                    case 'pms':
                                        echo 'предменструальный синдром';
                                        break;
                                    case 'mbov':
                                        echo 'благоприятные для зачатия дни';
                                        break;
                                    case 'fov':
                                        echo 'овуляция';
                                        break;
                                    case 'fsex':
                                        echo 'безопасный секс';
                                        break;
                                    case 'pfsex':
                                        echo 'условно безопасный секс';
                                        break;
                                }
                                ?>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="cal_item <?php echo $cell['cell'] ?>">
                        <ins><?php echo $cell['day'] ?></ins>
                        <?php if ($cell['cell'] != '') : ?>
                        <div class="hint" style="display: none;">
                            <?php
                            switch ($cell['cell']) {
                                case 'mens':
                                    echo 'менструация';
                                    break;
                                case 'pms':
                                    echo 'предменструальный синдром';
                                    break;
                                case 'mbov':
                                    echo 'благоприятные для зачатия дни';
                                    break;
                                case 'fov':
                                    echo 'овуляция';
                                    break;
                                case 'fsex':
                                    echo 'безопасный секс';
                                    break;
                                case 'pfsex':
                                    echo 'условно безопасный секс';
                                    break;
                            }
                            ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <?php endif ?>
                </td>
                <?php endforeach; ?>
        </tr>
    </table>
</div><!-- .mother_calendar -->
<div class="bottom-wrap">
    <div class="more_about_cal">
        <div class="next_month_cal">
            <span class="title_bl_ntmt">Календарь следующего месяца </span>

            <div class="mother_calendar">
                <div class="choice_month">
                    <span><?php echo HDate::ruMonth($model->next_month) ?>, <?php echo $model->next_month_year ?></span>
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
                        <?php $i = 0;
                        foreach ($next_data as $cell): ?>
                            <?php if ($i % 7 == 0 && $i != 0 && count($next_data) != $i)
                                echo "</tr><tr>";
                            $i++;?>
                            <td>
                                <?php if ($cell['other_month']): ?>
                                <div class="cal_item_default">

                                </div>
                                <?php else: ?>
                                <div class="cal_item <?php echo $cell['cell'] ?>">
                                    <ins><?php echo $cell['day'] ?></ins>
                                </div>
                                <?php endif ?>
                            </td>
                            <?php endforeach; ?>
                    </tr>
                </table>
            </div>
            <!-- .mother_calendar -->
        </div>
        <!-- .next_month_cal -->
        <div class="cal_helper">
            <span class="title_helper">Обозначения:</span>
            <ul>
                <li class="mens">- менструация</li>
                <li class="pms">- предменструальный синдром</li>
                <li class="mbov">- благоприятные для зачатия дни</li>
                <li class="fov">- овуляция</li>
                <li class="fsex">- безопасный секс</li>
                <li class="pfsex">- условно безопасный секс</li>
            </ul>
        </div>
        <!-- .cal_helper -->
        <div class="clear"></div>
        <!-- .clear -->
    </div>
    <!-- .more_about_cal -->
</div>