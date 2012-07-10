<?php
/**
 * @var $form CActiveForm
 */
$model = new MenstrualCycleForm();
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

Yii::app()->clientScript->registerMetaTag('Вы отмечаете ваш женский цикл по старинке – на календарике? Это немодно! Отмечайте свой менструальный цикл на компьютерном календаре и попутно узнавайте много важных нюансов о себе', 'description');
?>
<div class="mother_cal_banner">
    <span>Менструальный цикл – это биологические часы женщины, запущенные самой природой. Составьте свой женский календарь и проверьте – правильно ли идут ваши часы, а также узнайте массу другой полезной информации.</span>
</div><!-- .mother_cal_banner -->
<div class="calculate_tb">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'menstrual-cycle-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => '#',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('default/calculate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                return false;
                              }",
    )));
    echo $form->hiddenField($model, 'review_month', array('id' => 'review_month'));
    echo $form->hiddenField($model, 'review_year', array('id' => 'review_year'));?>
    <table>
        <tr>
            <th>День первого дня<br/>менструации предыдущего цикла:</th>
            <th>Длительность<br/> цикла</th>
            <th>Длительность<br/> менструации</th>
        </tr>
        <tr>
            <td>
                <div class="lists_td clearfix">
                    <div class="row">
                        <?php echo $form->dropDownList($model, 'day', HDate::Days(), array('class' => 'chzn', 'empty' => '-')); ?>
                        <?php echo $form->error($model, 'day'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->dropDownList($model, 'month', HDate::ruMonths(), array('class' => 'chzn', 'empty' => '-')); ?>
                        <?php echo $form->error($model, 'month'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->dropDownList($model, 'year', HDate::Range(date('Y') - 5, date('Y')), array('class' => 'chzn', 'empty' => '-')); ?>
                        <?php echo $form->error($model, 'year'); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'cycle', HDate::Range(21, 35), array('class' => 'chzn', 'empty' => '-')); ?>
                    <?php echo $form->error($model, 'cycle'); ?>
                </div>
            </td>
            <td>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'critical_period', HDate::Range(3, 7), array('class' => 'chzn', 'empty' => '-')); ?>
                    <?php echo $form->error($model, 'critical_period'); ?>
                </div>
            </td>
        </tr>
    </table>
    <button class="btn btn-yellow-medium" onclick="return false;"><span><span>Рассчитать</span></span></button>
    <div class="clear"></div>
    <?php echo $form->errorSummary($model); ?>

    <?php $this->endWidget(); ?>
    <div class="clear"></div>
    <!-- .clear -->
</div><!-- .calculate_tb -->
<div id="result">
    <div class="mother_calendar">
        <div class="choice_month">
            <a href="#" class="prev" id="prev-month">&larr;</a>
            <a href="#" class="next" id="next-month">&rarr;</a>
            <span><?php echo HDate::ruMonth(date('m')), ', ' . date('Y') ?></span>
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
            <?php
            $skip = date("w") + 1;
            if ($skip > 6)
                $skip = 0;

            $daysInMonth = date("t");
            $day = 1;
            $calendar_body = '';
            for ($i = 0; $i < 6; $i++) { // Внешний цикл для недель 6 с неполыми

                $calendar_body .= '<tr>'; // открываем тэг строки
                for ($j = 0; $j < 7; $j++) { // Внутренний цикл для дней недели

                    if (($skip > 0)or($day > $daysInMonth)) { // выводим пустые ячейки до 1 го дня ип после полного количства дней
                        if ($day > $daysInMonth) {
                            $daysOtherMonth = date("t", strtotime('+1 month', strtotime(date("Y-m-d"))));
                            $day2 = $day - $daysInMonth;
                        } else {
                            $daysOtherMonth = date("t", strtotime('-1 month', strtotime(date("Y-m-d"))));
                            $day2 = $daysOtherMonth - $skip + 1;
                        }
                        $calendar_body .= ' <td><div class="cal_item_default"><div class="cal_item "><ins>' . $day2 . '</ins>' .
                            '</div></div></td>';
                        $skip--;

                    }
                    else {

                        $calendar_body .= '<td><div class="cal_item"><ins>' . $day . '</ins></div></td>';
                        $day++; // увеличиваем $day
                    }

                }
                $calendar_body .= '</tr>'; // закрываем тэг строки
                if ($day > $daysInMonth)
                    break;
            }
            echo $calendar_body;
            ?>
        </table>
    </div>
    <!-- .mother_calendar -->
    <div id="next-m"></div>
</div>
<div class="seo-text">
    <span class="summary-title">Менструальный цикл – жизнь по расписанию</span>

    <p>Менструальный цикл &ndash; это не просто кровотечение по расписанию, это перестройка всего организма с одной
        единственной целью &ndash; дать начало новой человеческой жизни.</p>

    <p>Традиционно первым днём менструального цикла является начало менструации. В это время матка отторгает
        непригодившийся внутренний слой &ndash; эндометрий, освобождая место для роста нового.</p>

    <p>В это же время под контролем гипоталамуса в гипофизе вырабатываются гормоны, стимулирующие созревание яйцеклетки
        в яичнике женщины, начинает повышаться уровень женских половых гормонов &ndash; эстрогенов.</p>

    <p>После окончания менструации продолжает нарастать уровень эстрогенов, и к середине цикла он достигает максимума.
        Слизь, закрывающая канал шейки матки, становится жидкой, создавая условия для свободного проникновения в полость
        матки сперматозоидов, а созревшая яйцеклетка покидает фолликул яичника и отправляется навстречу сперматозоиду. В
        момент выхода яйцеклетки из яичника отмечается повышение температуры тела женщины примерно на полградуса.</p>

    <p>Если яйцеклетка не встретилась со сперматозоидом и беременность не состоялась, уровень эстрогенов резко
        снижается. Фолликул, который покинула яйцеклетка, становится жёлтым телом и начинает вырабатывать
        прогестерон.</p>

    <p>Через несколько дней жёлтое тело начинает уменьшаться в размерах, снижается его активность, параллельно
        уменьшается выработка прогестерона. В этот период у многих женщин развивается так называемый ПМС
        (предменструальный синдром), который проявляется резкой сменой настроения, раздражительностью, плаксивостью,
        депрессиями, появлением отёчности лица, нагрубанием молочных желез. Когда уровень прогестерона достигает
        минимума, температура тела женщины понижается на полградуса и начинается менструальное кровотечение, то есть
        следующий менструальный цикл.</p>

    <p>Длительность менструального цикла у каждой женщины своя &ndash; от 21 до 35 суток, но она постоянна. То есть если
        цикл составляет 28 дней в этом месяце, то и в следующем будет таким, и через полгода тоже. Многие женщины ведут
        календари, в которых отмечают начало и продолжительность каждой менструации.</p>

    <div class="brushed">
        <p style="margin-top:0;">Наш сервис предлагает завести себе электронный календарь, при помощи которого
            можно:</p>
        <ul>
            <li>составить индивидуальный график менструального цикла за любой промежуток времени (при этом все данные
                сохраняются, и их легко проанализировать);
            </li>
            <li>узнать вероятную дату овуляции;</li>
            <li>определить опасные и безопасные дни для наступления беременности;</li>
            <li>спрогнозировать начало ПМС и вовремя принять меры.</li>
        </ul>
        <p>Для этого нужно ввести все данные в специальные окошки. Нажать кнопку &laquo;рассчитать&raquo; и посмотреть
            результат, который наглядно покажет именно ваш менструальный цикл со всеми его особенностями, что,
            несомненно,
            поможет правильно спланировать свою личную жизнь. Кстати, вам не придётся повторять ввод данных &ndash; ваш
            женский календарь сохранится в вашем личном кабинете и будет постоянно доступен для пользования и занесения
            данных нового месяца.</p>
    </div>

</div><!-- .placenta_article -->
<div id="result2" style="display: none;"></div>