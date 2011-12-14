<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$model = new JapanCalendarForm;
?>
<script type="text/javascript">
    $(function () {
        //japan calendar
        $('body').delegate('#japan-prev-month', 'click', function () {
            var month = $('#japan_review_month').val();
            month--;
            if (month == 0) {
                month = 12;
            }
            $('#japan_review_month').val(month);
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/babySex/default/japanCalc") ?>",
                data:$("#japan-form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#japan-result").html(data);
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
                url:"<?php echo Yii::app()->createUrl("/babySex/default/japanCalc") ?>",
                data:$("#japan-form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#japan-result").html(data);
                }
            });
            return false;
        });

        $('.child_sex_japan_banner .calc_bt').click(function () {
            $("#japan_review_month").val($("#japan-conception-m").val());
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/babySex/default/japanCalc") ?>",
                data:jQuery(this).parents("form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#japan-result").html(data);
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
</script>
<div class="child_sex_japan_banner">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'japan-form',
    'enableAjaxValidation' => false,
));?>
    <div class="dad_bd">
        <span class="title_pt_bn">Месяц рождения отца:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'father_m', HDate::ruMonths(), array('id' => 'dad_mn_cal', 'class' => 'mn_cal')); ?>
            </li>
        </ul>
    </div>
    <!-- .dad_bd -->
    <div class="mam_bd">
        <span class="title_pt_bn">Месяц рождения матери:</span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('id' => 'mam_mn_cal', 'class' => 'mn_cal')); ?>
            </li>
        </ul>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>День и месяц зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <?php echo $form->dropDownList($model, 'baby_d', HDate::Days(), array('id' => 'ch_num_cal', 'class' => 'num_cal')); ?>
            </li>
            <li>
                <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('id' => 'ch_mn_cal', 'class' => 'mn_cal')); ?>
            </li>
        </ul>
    </div>
    <!-- .child_bd -->
    <?php echo $form->hiddenField($model, 'review_month', array('id' => 'japan_review_month')) ?>
    <input type="button" class="calc_bt" value="Рассчитать"/>
    <?php $this->endWidget(); ?>
</div><!-- .child_sex_banner -->
<div id="japan-result">

</div>