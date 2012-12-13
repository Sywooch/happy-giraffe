<?php
/**
 * @var $form CActiveForm
 */
$model = new OvulationForm();

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/ovulation.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCss('baby-gender-ovulation', '.child_sex_ovulyaciya_banner div.row {display: inline;}
.child_sex_ovulyaciya_banner .errorMessage {display: none !important;}');

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'ovulation-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => '',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('/babySex/ovulationCalc/'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                return false;
                              }",
    )));
echo $form->hiddenField($model, 'review_month', array('id' => 'review_month'));
echo $form->hiddenField($model, 'review_year', array('id' => 'review_year'));?>
<div class="child_sex_ovulyaciya_banner">
    <div class="dad_bd">
        <span class="title_pt_bn">Длительность цикла:</span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'cycle', HDate::Range(21, 35), array('class' => 'chzn num_cal', 'empty' => '')); ?>
                    <?php echo $form->error($model, 'cycle'); ?>
                </div>
            </li>
        </ul>
    </div>
    <!-- .dad_bd -->
    <div class="mam_bd">
        <span class="title_pt_bn">Дата первого дня менструации<br/> предыдущего цикла:</span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'day', HDate::Days(), array('class' => 'chzn num_cal', 'empty' => 'день')); ?>
                    <?php echo $form->error($model, 'day'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'month', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'month'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'year', HDate::Range(date('Y') - 1, date('Y')), array('class' => 'chzn yr_cal', 'empty' => 'год')); ?>
                    <?php echo $form->error($model, 'year'); ?>
                </div>
            </li>
        </ul>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>День зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'con_day', HDate::Days(), array('class' => 'chzn num_cal', 'empty' => 'день')); ?>
                    <?php echo $form->error($model, 'con_day'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'con_month', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'con_month'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'con_year', HDate::Range(date('Y') - 1, date('Y')), array('class' => 'chzn yr_cal', 'empty' => 'год')); ?>
                    <?php echo $form->error($model, 'con_year'); ?>
                </div>
            </li>
        </ul>
    </div>
    <!-- .child_bd -->
    <input type="submit" class="calc_bt" value="Рассчитать"/>
</div><!-- .child_sex_banner -->
<?php echo $form->errorSummary($model) ?>
<?php $this->endWidget(); ?>

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
</div>

<?php $this->widget('application.widgets.serviceSocial.serviceSocialWidget', array(
    'service' => $service,
    'image' => '/images/sex_child_ovulyaciya_bann.jpg',
    'description' => 'Определение пола ребенка по дате овуляции - единственный более-менее достоверный способ. За основу метода взяты различия в размерах и поведении...'
)); ?>

<br><br>
<div class="wysiwyg-content">
    <h1>Планирование пола ребенка по овуляции</h1>
    <p>Определение пола ребенка по дате овуляции - единственный более-менее достоверный способ. За основу метода взяты
        различия в размерах и поведении сперматозоидов, содержащих Х и Y-хромосомы, а также длительность жизни
        яйцеклетки.
        Точность метода зависит от того, насколько верно вы определили дату овуляции, поэтому будет лучше, если есть
        возможность взять усреднённые данные за 6 - 12 предыдущих циклов.</p>

    <div class="brushed">
        <p><b>Итак, вы вводите:</b></p>
        <ul>
            <li>дату начала менструации</li>
            <li>длительность менструации</li>
            <li>продолжительность менструального цикла</li>
        </ul>
        <p>Через несколько секунд вы получите результат и узнаете, кто же у вас появится – мальчик или девочка. Метод,
            конечно, не даёт 100% гарантии рождения ребёнка необходимого пола, однако он точнее прочих.</p>
    </div>

    <p><i><b>Важно!</b> Женщины, которым больше тридцати лет автоматически попадают в группу риска по рождению ребёнка с
        хромосомными аномалиями (болезнь Дауна, например). Однако многие учёные считают, что эти аномалии чаще
        возникают, когда яйцеклетка «стареет», то есть вышла из яичника сутки назад и больше. Наш сервис даёт
        возможность рассчитать дни повышенного риска для таких женщин. Обращайте внимание на специальные значки!</i></p>
</div>