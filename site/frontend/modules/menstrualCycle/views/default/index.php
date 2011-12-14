<?php
/**
 * @var $form CActiveForm
 */
$model = new MenstrualCycleForm();?>
<script type="text/javascript">
    var started = false;

    $(function () {
        $('#menstrual-cycle-form input.mth_calculate').click(function () {
            var d = new Date();
            $('#review_month').val(d.getMonth() + 1);
            $('#review_year').val(d.getFullYear());
            LoadCalendar();
            return false;
        });

        $('body').delegate('div.choice_month a#next-month', 'click', function () {
            var month = $('#review_month').val();
            if (month == '')
                return false;
            var year = $('#review_year').val();

            month++;
            if (month == 13) {
                month = 1;
                year++;
                $('#review_year').val(year);
            }
            $('#review_month').val(month);
            LoadCalendar();
            return false;
        });

        $('body').delegate('div.choice_month a#prev-month', 'click', function () {
            var month = $('#review_month').val();
            if (month == '')
                return false;
            var year = $('#review_year').val();

            var d = new Date();
            if (month == d.getMonth() + 1 && year == d.getFullYear())
                return false;

            month--;
            if (month == 0) {
                month = 12;
                year--;
                $('#review_year').val(year);
            }

            $('#review_month').val(month);
            LoadCalendar();
            return false;
        });

        $('body').delegate('.cal_item', 'hover', function (event) {
            if (event.type == 'mouseenter') {
                $(this).find('.hint').stop(true, true).fadeIn();
            } else {
                $(this).find('.hint').stop(true, true).fadeOut();
            }
        });
        $('body').delegate('.cal_item_default', 'hover', function (event) {
            if (event.type == 'mouseenter') {
                $(this).find('.hint').stop(true, true).fadeIn();
            } else {
                $(this).find('.hint').stop(true, true).fadeOut();
            }
        });

        function LoadCalendar() {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/menstrualCycle/default/calculate") ?>",
                data:$("#menstrual-cycle-form").serialize(),
                type:"POST",
                success:function (data) {
//                    $('#result').html(data);
                    $('#result').animate({opacity: 0}, 'fast', 'swing', function(){
                        $('#result').html(data);
                        $('#result').animate({opacity: 1}, 'fast');
                    });

//                    $('#result2').html(data);
//                    $('#result > .mother_calendar .calendar_body').animate({opacity:0}, 'fast', 'swing', function () {
//                        $('#result > .mother_calendar .calendar_body').html($('#result2 > .mother_calendar .calendar_body').html());
//                        $('#result > .mother_calendar .calendar_body').animate({opacity:1}, 'fast', 'swing');
//                    });
//                    if (started) {
//                        $('#result > .mother_calendar .choice_month span').animate({opacity:0}, 'fast', 'swing', function () {
//                            $('#result > .mother_calendar .choice_month span').html($('#result2 > .mother_calendar .choice_month span').html());
//                            $('#result > .mother_calendar .choice_month span').animate({opacity:1}, 'fast');
//                        });
//                    }
//                    if (started) {
//                        $('#next-m .next_month_cal .mother_calendar').animate({opacity:0}, 300, 'swing', function () {
//                            $('#next-m .next_month_cal .mother_calendar').html($('#result2 .next_month_cal .mother_calendar').html());
//                            $('#next-m .next_month_cal .mother_calendar').animate({opacity:1}, 300);
//                        });
//                    }
//                    else {
//                        $('#next-m').animate({opacity:0}, 1, 'swing', function () {
//                            $('#next-m').html($('#result2 .bottom-wrap').html());
//                            $('#next-m').animate({opacity:1}, 300);
//                        });
//                        started = true;
//                    }
                }
            });
        }
    });
</script>

<div class="mother_cal_banner">
    <span>Составьте свой женский календарь, составьте свой женский</span><br/>
    <span>календарь, составьте свой женский календарь, составьте свой</span><br/>
    <span>женский календарь.</span>
</div><!-- .mother_cal_banner -->
<div class="calculate_tb">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'menstrual-cycle-form',
    'enableAjaxValidation' => false,
));
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
                <ul class="lists_td">
                    <li>
                        <?php echo $form->dropDownList($model, 'day', HDate::Days(), array('id' => 'num_cal', 'class' => 'num_cal')); ?>
                    </li>
                    <li>
                        <?php echo $form->dropDownList($model, 'month', HDate::ruMonths(), array('id' => 'mn_cal', 'class' => 'mn_cal')); ?>
                    </li>
                    <li>
                        <?php echo $form->dropDownList($model, 'year', HDate::Range(date('Y')-1, date('Y')), array('id' => 'yr_cal', 'class' => 'yr_cal')); ?>
                    </li>
                </ul>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'cycle', HDate::Range(21, 35), array('id' => 'cl_cal', 'class' => 'num_cal')); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($model, 'critical_period', HDate::Range(3, 7), array('id' => 'men_cal', 'class' => 'num_cal')); ?>
            </td>
        </tr>
    </table>
    <input type="button" class="mth_calculate" value="Рассчитать"/>
    <?php $this->endWidget(); ?>
    <div class="clear"></div>
    <!-- .clear -->
</div><!-- .calculate_tb -->
<div id="result">
<div class="mother_calendar">
<div class="choice_month">
    <a href="#" class="l_arr_mth" id="prev-month">&larr;</a>
    <a href="#" class="r_arr_mth_active" id="next-month">&rarr;</a>
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
<tr>
    <td>
        <div class="cal_item">

        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">

        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">

        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>1</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>2</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>3</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>4</ins>
        </div>
        <!-- .cal_item -->
    </td>
</tr>
<tr>
    <td>
        <div class="cal_item">
            <ins>5</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>6</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>7</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>8</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>9</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>10</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>11</ins>
        </div>
        <!-- .cal_item -->
    </td>
</tr>
<tr>
    <td>
        <div class="cal_item">
            <ins>12</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>13</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>14</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>15</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>16</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>17</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>18</ins>
        </div>
        <!-- .cal_item -->
    </td>
</tr>
<tr>
    <td>
        <div class="cal_item">
            <ins>19</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>20</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>21</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>22</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>23</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>24</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>25</ins>
        </div>
        <!-- .cal_item -->
    </td>
</tr>
<tr>
    <td>
        <div class="cal_item">
            <ins>26</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>27</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>28</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>29</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>30</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">
            <ins>31</ins>
        </div>
        <!-- .cal_item -->
    </td>
    <td>
        <div class="cal_item">

        </div>
        <!-- .cal_item -->
    </td>
</tr>
</table>
</div>
<!-- .mother_calendar -->
<div id="next-m"></div>
</div>
<div class="article_p">
    <span class="article_title">Женский календарь бла бла бла</span>

    <p>Наступление беременности сопровождается значительными изменениями в организме женщины. Это и понятно: теперь ему
        приходится работать, как говорят в народе, «за двоих». Увеличивается слой подкожно-жировой клетчатки, которая
        является своеобразным «депо» воды, питательных веществ и витаминов для благополучного развития ребенка. Но это
        не единственный фактор, влияющий на вес во время беременности. Рассмотрим данный вопрос подробнее.<br/>Вес при
        беременности увеличивается, потому что:</p>
    <ul>
        <li>
            <ins>*</ins>
            растет плодное яйцо (плод + плодные оболочки),
        </li>
        <li>
            <ins>*</ins>
            развивается плацента,
        </li>
        <li>
            <ins>*</ins>
            увеличивается вес и размеры матки (как собственно мышечной ткани, так и околоплодных вод),
        </li>
        <li>
            <ins>*</ins>
            изменяется толщина подкожно-жирового слоя,
        </li>
        <li>
            <ins>*</ins>
            увеличиваются молочные железы.
        </li>
    </ul>
    <p>На вес при беременности влияют:</p>
    <ul>
        <li>
            <ins>*</ins>
            Возраст: чем старше женщина, тем больший вес во время беременности она набирает.
        </li>
        <li>
            <ins>*</ins>
            Самочувствие. При токсикозе на раннем сроке и частой рвоте женщина может похудеть, а при токсикозе на
            последних месяцах беременности, сопровождающемся нефропатией и отеками, вес быстро нарастает.
        </li>
        <li>
            <ins>*</ins>
            Многоплодная беременность – понятно, что два или три ребенка весят больше, чем один.
        </li>
        <li>
            <ins>*</ins>
            Патологическое течение беременности, например многоводие при внутриутробных инфекциях или отеки при
            сопутствующих заболеваниях почек.
        </li>
        <li>
            <ins>*</ins>
            Индекс массы тела (ИМТ) до беременности. ИМТ – это отношение веса женщины в килограммах к квадрату ее роста
            в метрах. Чем меньше ИМТ, тем обычно больше прибавка веса
        </li>
    </ul>
    <p>Существуют ли стандарты набора веса при беременности?</p>

    <p>Да, существуют. Однако нужно помнить: набор веса беременными индивидуален и зависит от многих факторов. Очевидно,
        что полная женщина и совсем худенькая, крупная и миниатюрная наберут разное количество килограммов. Поэтому вес
        во время беременности оценивают по специальным таблицам, опираясь на ИМТ.<br/>Чем опасна низкая прибавка веса?
    </p>

    <p>Малый набор массы тела при беременности опасен тем, что ребенок будет получать недостаточное количество
        питательных веществ и начнет отставать в своем развитии.</p>
</div><!-- .placenta_article -->
<div id="result2" style="display: none;"></div>