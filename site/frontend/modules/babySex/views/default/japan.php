<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$model = new JapanCalendarForm;
$js =    "$(function () {
        //japan calendar
        $('body').delegate('#japan-prev-month', 'click', function () {
            var month = $('#japan_review_month').val();
            month--;
            if (month == 0) {
                month = 12;
            }
            $('#japan_review_month').val(month);
            $.ajax({
                url:'".Yii::app()->createUrl("/babySex/default/japanCalc")."',
                data:$('#japan-form').serialize(),
                type:'POST',
                success:function (data) {
                    ShowResult(data);
                }
            });
            return false;
        });

        $('body').delegate('#japan-next-month', 'click', function () {
            var month = $('#japan_review_month').val();
            month++;
            if (month == 13) {
                month = 1;
            }
            $('#japan_review_month').val(month);
            $.ajax({
                url:'".Yii::app()->createUrl("/babySex/default/japanCalc")."',
                data:$('#japan-form').serialize(),
                type:'POST',
                success:function (data) {
                    ShowResult(data);
                }
            });
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
    });

        function StartCalc() {
            $('#japan_review_month').val($('#JapanCalendarForm_baby_m').val());
            $.ajax({
                url:'".Yii::app()->createUrl("/babySex/default/japanCalc")."',
                data:$('#japan-form').serialize(),
                type:'POST',
                success:function (data) {
                    ShowResult(data);
                }
            });
            return false;
        }

        function ShowResult(data) {
            $('#japan-result').html(data);
            $('html,body').animate({scrollTop: $('#japan-result').offset().top},'fast');
        }
    ";
    Yii::app()->clientScript
        ->registerScript('japan-baby-gender',$js);
?>
<div class="child_sex_japan_banner">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'japan-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('/babySex/default/japanCalc'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                return false;
                              }",
    ))); ?>
    <div class="dad_bd">
        <span class="title_pt_bn">Месяц рождения отца:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'father_m', HDate::ruMonths(), array('class' => 'chzn', 'empty'=>'--')); ?>
                <?php echo $form->error($model, 'father_m'); ?>
            </li>
        </ul>
    </div>
    <!-- .dad_bd -->
    <div class="mam_bd">
        <span class="title_pt_bn">Месяц рождения матери:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('class' => 'chzn', 'empty'=>'--')); ?>
                <?php echo $form->error($model, 'mother_m'); ?>
            </li>
        </ul>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>День и месяц зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'baby_d', HDate::Days(), array('class' => 'chzn', 'empty'=>'--')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('class' => 'chzn', 'empty'=>'--')); ?>
            </li>
        </ul>
        <?php echo $form->error($model, 'baby_d'); ?>
        <?php echo $form->error($model, 'baby_m'); ?>
    </div>
    <!-- .child_bd -->
    <?php echo $form->hiddenField($model, 'review_month', array('id' => 'japan_review_month')) ?>
    <input type="submit" class="calc_bt" value="Рассчитать"/>
    <?php $this->endWidget(); ?>
</div><!-- .child_sex_banner -->
<div id="japan-result">

</div>
<div class="seo-text">
    <div class="summary-title">Японский метод</div>
    <p>Все жители Японии, а в особенности семейные пары, очень трепетно относятся к детям. Иметь продолжателей своего
        рода – основная обязанность каждой семьи. Желательно, чтобы в семье был мальчик, – для отцов семейства это очень
        важно. Если в семье рождаются одни девочки, мужчина может прибегнуть к связи «на стороне» или к усыновлению
        желаемого наследника – такие в этой стране правила. Наличие детей определяет статус и уважение японцев в
        обществе. Поэтому семейные пары часто прибегают к планированию будущего пола малыша с помощью своего исконного
        традиционного метода.</p>

    <p>Планирование пола будущего малыша при японском методе рассчитывается, исходя из данных родителей. Это таблица,
        содержащая месяцы рождения отца и матери и месяцы зачатия. Если папа и мама, к примеру, родились в ноябре, то
        девочку они смогут зачать в июле, а мальчика – в октябре. Эффективность данного метода составляет около 55% и не
        является гарантом желаемого результата. Но, как говорится, «попытка – не пытка». Вы можете воспользоваться этим
        методом, считать самим не придется: вы закладываете данные в систему, она их обрабатывает и сообщает вам о
        вероятности рождения мальчика или девочки.</p>
</div>