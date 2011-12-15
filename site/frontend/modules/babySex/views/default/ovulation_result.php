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
           class="l_arr_mth_active" id="prev-month">&larr;</a>
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
                        <div class="cal_item baby-<?php echo $cell['sex'] ?>">
                            <ins><?php echo $cell['day'] ?></ins>
                            <?php if ($cell['sex'] != 0) : ?>
                            <div class="hint" style="display: none;">
                                <?php
                                switch ($cell['sex']) {
                                    case 1:
                                        echo 'мальчик';
                                        break;
                                    case 2:
                                        echo 'девочка';
                                        break;
                                    case 3:
                                        echo 'мальчик, но женщинам за 30 лучше не рисковать';
                                        break;
                                }
                                ?>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="cal_item baby-<?php echo $cell['sex'] ?>">
                        <ins><?php echo $cell['day'] ?></ins>
                        <?php if ($cell['sex'] != 0) : ?>
                        <div class="hint" style="display: none;">
                            <?php
                            switch ($cell['sex']) {
                                case 1:
                                    echo 'мальчик';
                                    break;
                                case 2:
                                    echo 'девочка';
                                    break;
                                case 3:
                                    echo 'мальчик, но женщинам за 30 лучше не рисковать';
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