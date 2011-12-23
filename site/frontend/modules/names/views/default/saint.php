<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Name
 */
?>
<script type="text/javascript">
    $(function () {
        $('.mth_calculate').click(function () {
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/names/default/saintCalc") ?>",
                data:$("#date-form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#result").fadeOut(100, function () {
                        $("#result").html(data);
                        $("#result").fadeIn(100);
                    });
                }
            });
        });
    });
</script>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'date-form',
    'enableAjaxValidation' => false,
));?>
<?php echo $form->dropDownList($model, 'month', HDate::ruMonths(), array('id' => 'mn_cal', 'class' => 'mn_cal')); ?>
<?php echo $form->dropDownList($model, 'day', HDate::Days(), array('id' => 'mon', 'class' => 'num_cal', 'empty'=>' ')); ?>
<?php echo $form->dropDownList($model, 'gender', array('1'=>'boy','2'=>'girl'), array('id' => 'gender', 'class' => 'num_cal', 'empty'=>' ')); ?>
<input type="button" class="mth_calculate" value="Рассчитать"/>
<?php $this->endWidget(); ?>

<div id="result">

</div>