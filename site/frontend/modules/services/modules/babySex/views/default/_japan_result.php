<?php
/* @var $model BloodRefreshForm
 * @var $form CActiveForm
 */
?>
<div class="mother_calendar">
    <div class="choice_month">
        <a href="#" class="prev" id="japan-prev-month">&larr;</a>
        <a href="#" class="next" id="japan-next-month">&rarr;</a>
        <span><?php echo  HDate::ruMonth($month) ?></span>
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

                    <div class="cal_item<?php if ($cell['day'] == $model->baby_d && !$cell['other_month'] && $month == $model->baby_m ) echo ' active_item' ?>">
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

        <p>Японский метод, основанный на датах рождения отца, матери и месяце зачатия говорит именно об этом. Точность
            метода 55% и он не гарантирует рождения девочки, зато так приятно помечтать об этом.</p>
    </div>
</div>
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_BOY): ?>
<div class="wh_wait wh_son">
    <div class="img-box">
        <img src="/images/baby_boy.jpg">
    </div>
    <div class="text">
        <span class="title_wh_wait">Поздравляем! У вас будет мальчик! </span>

        <p>Так получается, исходя из дат рождения отца и матери, а также месяца зачатия. Этот известный японский метод точен
            на 55%, поэтому не гарантирует рождения мальчика, зато позволяет помечтать об этом.</p>
    </div>
</div>
<?php endif ?>
<?php if ($gender == BloodRefreshForm::IS_UNKNOWN): ?>
<div class="wh_wait wh_unknown">
    <div class="img-box">
        <img src="/images/baby_unknown.png">
    </div>
    <div class="text">
        <p><b>Мальчик или девочка?</b> В вашем случае однозначного ответа японский метод не даёт. Попробуйте воспользоваться
            другими способами определения пола будущего ребёнка.</p>
    </div>
</div>
<?php endif ?>
