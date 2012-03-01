<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$year = date('Y');
$model = new BloodRefreshForm();
$js = "
$(function () {
        //blood refresh
        $('body').delegate('#blood-refresh-prev-month', 'click', function () {
            var month = $('#blood_refr_review_month').val();
            var year = $('#blood_refr_review_year').val();
            month--;
            if (month == 0) {
                month = 12;
                year--;
                $('#blood_refr_review_year').val(year);
            }
            $('#blood_refr_review_month').val(month);
            $.ajax({
                url:'" . Yii::app()->createUrl("/babySex/default/bloodUpdate") . "',
                data:$('#blood-refresh-form').serialize(),
                type:'POST',
                success:function (data) {
                    ShowResult(data);
                }
            });
            return false;
        });

        $('body').delegate('#blood-refresh-next-month', 'click', function () {
            var month = $('#blood_refr_review_month').val();
            var year = $('#blood_refr_review_year').val();
            month++;
            if (month == 13) {
                month = 1;
                year++;
                $('#blood_refr_review_year').val(year);
            }
            $('#blood_refr_review_month').val(month);
            $.ajax({
                url:'" . Yii::app()->createUrl("/babySex/default/bloodUpdate") . "',
                data:$('#blood-refresh-form').serialize(),
                type:'POST',
                success:function (data) {
                    ShowResult(data);
                }
            });
            return false;
        });

        $('input.calc_bt').click(function () {
            $('#blood_refr_review_year').val($('#ch_yr_cal').val());
            $('#blood_refr_review_month').val($('#ch_mn_cal').val());
            $.ajax({
                url:'" . Yii::app()->createUrl("/babySex/default/bloodUpdate") . "',
                data:$('#blood-refresh-form').serialize(),
                type:'POST',
                success:function (data) {
                    ShowResult(data);
                }
            });
        });

        function ShowResult(data) {
            $('#blood-update-result').html(data);
            $('html,body').animate({scrollTop: $('#blood-update-result').offset().top},'fast');
        }

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
    });
";
Yii::app()->clientScript->registerScript('blood-update', $js);
?>
<div class="child_sex_banner">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'blood-refresh-form',
    'enableAjaxValidation' => false,
));?>
    <div class="dad_bd">
        <span class="title_pt_bn">День рождения отца:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'father_d', HDate::Days(), array('id' => 'dad_num_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'father_m', HDate::ruMonths(), array('id' => 'dad_mn_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'father_y', HDate::Range($year - 65, $year - 15), array('id' => 'dad_yr_cal', 'class' => 'chzn')); ?>
            </li>
        </ul>
    </div>
    <!-- .dad_bd -->
    <div class="mam_bd">
        <span class="title_pt_bn">День рождения матери:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'mother_d', HDate::Days(), array('id' => 'mam_num_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('id' => 'mam_mn_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'mother_y', HDate::Range($year - 65, $year - 15), array('id' => 'mam_yr_cal', 'class' => 'chzn')); ?>
            </li>
        </ul>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>День зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'baby_d', HDate::Days(), array('id' => 'ch_num_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('id' => 'ch_mn_cal', 'class' => 'chzn')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'baby_y', HDate::Range(1950, $year), array('id' => 'ch_yr_cal', 'class' => 'chzn')); ?>
            </li>
        </ul>
    </div>
    <!-- .child_bd -->
    <?php echo $form->hiddenField($model, 'review_month', array('id' => 'blood_refr_review_month')) ?>
    <?php echo $form->hiddenField($model, 'review_year', array('id' => 'blood_refr_review_year')) ?>
    <input type="button" class="calc_bt" value="Рассчитать"/>
    <?php $this->endWidget(); ?>
</div><!-- .child_sex_banner -->
<div id="blood-update-result">

</div>
<div class="seo-text">
    <div class="summary-title">Определение пола будущего ребенка по дате рождения родителей</div>
    <p>В основе данного метода лежит цикличность обновления крови женщины и мужчины в зависимости от их возраста. Эти
        циклы представляют собой определенные временные периоды, которые начинаются со дня рождения. Если на момент
        зачатия «моложе» была кровь женщины – значит, родится девочка, если кровь мужчины – мальчик.</p>

    <p>По правде говоря, эффективность данного метода недостаточно высока. Так что, если результат не оправдал ваших
        ожиданий – не расстраивайтесь. Главное – чтобы это был здоровый малыш, а поэкспериментировать вы сможете еще –
        со следующим ребенком.</p>
</div>