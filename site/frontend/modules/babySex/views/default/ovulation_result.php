<?php
/* @var $model OvulationForm
 * @var $form CActiveForm
 */
?>
<div class="mother_calendar">
    <div class="choice_month">
        <a href="#" class="prev" id="prev-month">&larr;</a>
        <a href="#" class="next" id="next-month">&rarr;</a>
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
                    elseif ($cell['sex'] == 3)
                        $class = 'boy_cl';
                    else
                        $class = '';?>
                    <div class="cal_item_default">
                        <div
                            class="cal_item <?php echo $class ?>">
                            <ins><?php echo $cell['day'] ?></ins>
                            <?php if ($cell['sex'] == 3): ?>
                            <div class="hint" style="display: none;">
                                Мальчик, но женщинам за 30 лучше не рисковать
                            </div>
                            <div class="attention_calc"></div>
                            <?php endif ?>
                            <i class="icon"></i>
                        </div>
                    </div>

                    <?php else: ?>

                    <?php
                    $baby = '';
                    if ($cell['sex'] == BloodRefreshForm::IS_BOY)
                        $baby = 'boy';
                    elseif ($cell['sex'] == BloodRefreshForm::IS_GIRL)
                        $baby = 'girl';
                    elseif ($cell['sex'] == 3)
                        $baby = 'boy';
                    ?>
                    <div class="cal_item<?php if ($cell['day'] == $model->con_day
                        && !$cell['other_month'] && $month == $model->con_month && $year == $model->con_year
                    ) echo ' active_item' ?> <?php echo $baby ?>">
                        <ins><?php echo $cell['day'] ?></ins>
                        <i class="icon"></i>
                        <?php if ($cell['sex'] == 3): ?>
                        <div class="hint" style="display: none;">
                            Мальчик, но женщинам за 30 лучше не рисковать
                        </div>
                        <div class="attention_calc"></div><!-- .attention_calc -->
                        <?php endif ?>
                    </div>

                    <?php endif; ?>
                </td>
                <?php } ?>
        </tr>
    </table>
</div><!-- .mother_calendar -->
<?php if ($gender == BloodRefreshForm::IS_GIRL): ?>
<div class="wh_wait wh_daughter">
    <div class="img-box">
        <img src="/images/baby_girl.jpg">
    </div>
    <div class="text">
        <span class="title_wh_wait">Девочка</span>

        <p>Поздравляем! У вас будет девочка! Сперматозоид с Х-хромосомой дождётся прихода яйцеклетки и оплодотворит её.
            Однако метод не даёт 100% гарантии. Поэтому при сбое менструального цикла вполне может родиться мальчик.</p>
    </div>
</div>
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_BOY): ?>
<div class="wh_wait wh_son">
    <div class="img-box">
        <img src="/images/baby_boy.jpg">
    </div>
    <div class="text">
    <span class="title_wh_wait">Мальчик</span>

    <p>Поздравляем! У вас будет мальчик! Сперматозоид с Y-хромосомой должен оказаться быстрее всех у яйцеклетки и
        оплодотворить её. Однако метод не даёт 100% гарантии. При сбое менструального цикла может появиться и
        девочка.</p>
</div></div>
<?php endif ?>
<?php if ($gender == 3): ?>
<div class="wh_wait wh_son" style="margin-bottom: 30px;">
    <div class="img-box">
        <img src="/images/baby_boy.jpg">
    </div>
    <div class="text">
    <span class="title_wh_wait">Мальчик</span>

    <p style="padding-bottom: 6px;">Поздравляем! У вас будет мальчик! Сперматозоид с Y-хромосомой должен оказаться
        быстрее всех у яйцеклетки и
        оплодотворить её. Однако метод не даёт 100% гарантии. При сбое менструального цикла может появиться и
        девочка.</p>

    <p><i><b>Внимание!</b> Если вам больше 30 лет – повышен риск рождения ребёнка с хромосомной аномалией. Если вы
        беременны и
        предполагаете, что зачатие произошло именно в этот день – не волнуйтесь! Обязательно пройдите специальные
        обследования в первом и втором триместрах беременности, чтобы точно знать, что родится здоровый малыш.</i></p>
</div></div>
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_UNKNOWN): ?>
<div class="wh_wait wh_unknown">
    <div class="img-box">
        <img src="/images/baby_unknown.png">
    </div>
    <div class="text">
    <span class="title_wh_wait">Гораздо раньше или позже овуляции</span>

    <p>Рассчитать пол ребёнка невозможно, так как в этот день зачатие, скорее всего, не состоится. При сбое
        менструального цикла зачатие возможно, но пол прогнозировать лучше при помощи другого метода.</p>
</div></div>
<?php endif ?>
