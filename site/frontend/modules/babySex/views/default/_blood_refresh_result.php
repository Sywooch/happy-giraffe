<?php
/* @var $model BloodRefreshForm
 * @var $form CActiveForm
 */
?>
<?php //echo 'отработало за '.sprintf('%0.5f', Yii::getLogger()->getExecutionTime()) ?>
<div class="mother_calendar">
    <div class="choice_month">
        <a href="#" class="prev" id="blood-refresh-prev-month">&larr;</a>
        <a href="#" class="next" id="blood-refresh-next-month">&rarr;</a>
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
                        <div class="cal_item <?php echo $class ?>">
                            <ins><?php echo $cell['day'] ?></ins>
                            <i class="icon<?php echo ' opacity-' . $cell['opacity'] ?>"></i>
                        </div>

                        <?php if ($cell['probability'] > 50): ?>
                        <div class="hint" style="display: none;">
                            <?php echo $cell['probability'] ?> %
                        </div>
                        <?php endif ?>
                    </div>

                    <?php else: ?>

                    <div
                        class="cal_item<?php if ($cell['day'] == $model->baby_d && !$cell['other_month'] && $month == $model->baby_m) echo ' active_item' ?>">
                        <?php if ($cell['sex'] == BloodRefreshForm::IS_BOY): ?>
                        <div class="boy">
                            <ins><?php echo $cell['day'] ?></ins>
                            <i class="icon opacity-<?php echo $cell['opacity'] ?>"></i>
                        </div>
                        <?php endif; ?>
                        <?php if ($cell['sex'] == BloodRefreshForm::IS_GIRL): ?>
                        <div class="girl">
                            <ins><?php echo $cell['day'] ?></ins>
                            <i class="icon opacity-<?php echo $cell['opacity'] ?>"></i>
                        </div>
                        <?php endif; ?>
                        <?php if ($cell['sex'] == BloodRefreshForm::IS_UNKNOWN): ?>
                        <ins><?php echo $cell['day'] ?></ins>
                        <i class="icon"></i>
                        <?php endif; ?>

                        <?php if ($cell['probability'] > 50): ?>
                        <div class="hint" style="display: none;"><?php echo $cell['probability'] ?> %</div>
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
        <span class="title_wh_wait">Поздравляем! У вас будет девочка!</span>

        <p>Это значит, что на момент зачатия кровь папы оказалась более «молодой». Считается, что кровь мужчины
            обновляется каждые 4 года, а у женщины – каждые три. Обновление крови происходит при каждой массивной
            кровопотере (роды, аборт, хирургическая операция, переливание крови или сдача крови донором). Точность
            метода невысокая, поэтому он не даёт гарантии рождения мальчика.</p>
    </div>
</div>
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_BOY): ?>
<div class="wh_wait wh_son">
    <div class="img-box">
        <img src="/images/baby_boy.jpg">
    </div>
    <div class="text">
        <span class="title_wh_wait">Поздравляем! У вас будет мальчик!</span>

        <p>Это значит, что кровь мамы на момент зачатия оказалась «моложе» крови папы. Кровь женщины обновляется раз в
            три года, а мужчины – раз в четыре. Однако это может случиться и внепланово, при массивной кровопотере
            (хирургические операции, донорство, роды, переливание крови, аборт). Менструальные кровотечения не
            учитываются. Метод имеет невысокую точность, поэтому гарантии рождения девочки не даёт.</p>
    </div>
</div>
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_UNKNOWN): ?>
<div class="wh_wait wh_unknown">
    <div class="img-box">
        <img src="/images/baby_unknown.png">
    </div>
    <div class="text">
        <p><b>Мальчик или девочка?</b> У мамы и папы кровь обновилась примерно в одно время. Поэтому точно вычислить пол
            будущего ребёнка не получилось. Попробуйте воспользоваться другими методами и определить, кто у вас родится
            –
            мальчик или девочка.</p>
    </div>
</div>
<?php endif ?>
