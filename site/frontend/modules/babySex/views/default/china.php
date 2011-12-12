<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$year = date('Y');
$model = new ChinaCalendarForm();
?>
<script type="text/javascript">
    $(document).ready(function () {
        var parent = $(this);

        var month = $('#china-conception-m');
        var submitBut = $('#china-submit');

        submitBut.click(function () {
            var d = new Date();
            var baby_m = d.getMonth() + 1;
            var baby_y = $('#china-conception-y').val();
            var mother_m = parseInt($('#china-mother-m').val());
            var baby_m = month.val();
            var mother_y = $('#china-mother-y').val();

            var age = baby_y - mother_y - 1;
            if (baby_m <= mother_m)
                var age = baby_y - mother_y;

            var id = 'child_' + age + '_' + month.val();
            var cell = $('#' + id);

            if (parent.data('activeCell')) {
                if (parent.data('activeCell').hasClass('sex-test-table-cur-boy')) {
                    parent.data('activeCell').removeClass('sex-test-table-cur-boy');
                } else if (parent.data('activeCell').hasClass('sex-test-table-cur-girl')) {
                    parent.data('activeCell').removeClass('sex-test-table-cur-girl');
                }
            }

            parent.data('activeCell', cell.children());

            if (cell.children().hasClass('sex-test-table-girl')) {
                console.log('У вас будет девочка!');
                parent.data('activeCell').addClass('sex-test-table-cur-girl');
            } else {
                console.log('У вас будет мальчик!');
                parent.data('activeCell').addClass('sex-test-table-cur-boy');
            }
        });


    });
</script>
<div id="china-calendar">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'china-calendar-form',
    'enableAjaxValidation' => false,
));?>

    <big>Год и месяц рождения матери:</big>
    <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('id' => 'china-mother-m', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'mother_y', HDate::Range($year - 18, 1950), array('id' => 'china-mother-y', 'class' => 'wid100')); ?>
    <br>
    <big>Месяц зачатия</big>
    <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('id' => 'china-conception-m', 'class' => 'wid100')); ?>
    <?php echo $form->dropDownList($model, 'baby_y', HDate::Range($year+2, 2000), array('id' => 'china-conception-y', 'class' => 'wid100')); ?>
    <br>
    <?php echo $form->hiddenField($model, 'review_month', array('id' => 'china_review_month')) ?>
    <?php echo $form->hiddenField($model, 'review_year', array('id' => 'china_review_year')) ?>

    <?php echo CHtml::link('<span><span>Рассчитать</span></span>', '', array(
//        'type' => 'POST',
//        'data' => 'js:jQuery(this).parents("form").serialize()',
//        'success' => 'function(data){
//            $("#china-calendar-result").html(data);
//            $("#china_review_year").val($("#china-conception-y").val());
//            $("#china_review_month").val($("#china-conception-m").val());
//        }'
//    ),
//    array(
    'class' => 'btn btn-yellow-medium',
    'id' => 'china-submit'
)); ?>

    <?php $this->endWidget(); ?>
</div>
<div id="china-calendar-result">

</div>

<div class="sex-test-child-table-left">
<table class="sex-test-child-table" cellspacing="0">
<thead>
<tr>
    <th rowspan="2" class="sext-test-mother-age">
        Возраст матери
    </th>
    <th colspan="11" class="sext-test-months-head">
        Месяц
    </th>
    <th class="sex-test-months-right">&nbsp;</th>
</tr>
<tr class="sext-test-months">
    <th>Январь</th>

    <th>Февр</th>
    <th>Март</th>
    <th>Апр</th>
    <th>Май</th>
    <th>Июнь</th>
    <th>Июль</th>

    <th>Август</th>
    <th>Сент</th>
    <th>Окт</th>
    <th>Нояб</th>
    <th>Декаб</th>
</tr>

</thead>
<tbody>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">18</td>
    <td id="child_18_1">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_18_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_18_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_18_4">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_18_5">
        <div class="sex-test-table-inner  sex-test-table-boy">

            <div></div>
        </div>
    </td>
    <td id="child_18_6">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_18_7">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_18_8">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>

    <td id="child_18_9">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_18_10">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_18_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td class="sex-test-table-last" id="child_18_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">19</td>
    <td id="child_19_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
    <td id="child_19_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_19_3">
        <div class="sex-test-table-inner  sex-test-table-boy">

            <div></div>
        </div>
    </td>
    <td id="child_19_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_19_5">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_19_6">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>

    <td id="child_19_7">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_19_8">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_19_9">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_19_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_19_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td class="sex-test-table-last" id="child_19_12">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">20</td>
    <td id="child_20_1">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_20_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_20_3">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_20_4">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>

    <td id="child_20_5">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_20_6">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_20_7">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_20_8">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
    <td id="child_20_9">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_20_10">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_20_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td class="sex-test-table-last" id="child_20_12">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">21</td>
    <td id="child_21_1">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_21_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_21_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_21_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_21_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_21_6">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_21_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_21_8">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_21_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_21_10">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_21_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td class="sex-test-table-last" id="child_21_12">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">22</td>

    <td id="child_22_1">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_22_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_22_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_22_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_22_5">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_22_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_22_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_22_8">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_22_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_22_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_22_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_22_12">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">23</td>

    <td id="child_23_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_23_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_23_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_23_4">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
    <td id="child_23_5">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_23_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_23_7">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_23_8">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_23_9">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>

    <td id="child_23_10">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_23_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_23_12">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">24</td>

    <td id="child_24_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_24_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_24_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_24_4">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
    <td id="child_24_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_24_6">
        <div class="sex-test-table-inner  sex-test-table-boy">

            <div></div>
        </div>
    </td>
    <td id="child_24_7">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_24_8">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_24_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_24_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_24_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_24_12">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">25</td>

    <td id="child_25_1">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_25_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_25_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_25_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_25_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_25_6">
        <div class="sex-test-table-inner  sex-test-table-boy">

            <div></div>
        </div>
    </td>
    <td id="child_25_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_25_8">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_25_9">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>

    <td id="child_25_10">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_25_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_25_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">26</td>

    <td id="child_26_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_26_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_26_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_26_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_26_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_26_6">
        <div class="sex-test-table-inner  sex-test-table-boy">

            <div></div>
        </div>
    </td>
    <td id="child_26_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_26_8">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_26_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_26_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_26_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_26_12">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">27</td>

    <td id="child_27_1">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_27_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_27_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_27_4">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
    <td id="child_27_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_27_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_27_7">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_27_8">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_27_9">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>

    <td id="child_27_10">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_27_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_27_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">28</td>

    <td id="child_28_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_28_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_28_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_28_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_28_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_28_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_28_7">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_28_8">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_28_9">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>

    <td id="child_28_10">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_28_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_28_12">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">29</td>

    <td id="child_29_1">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_29_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_29_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_29_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_29_5">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_29_6">
        <div class="sex-test-table-inner  sex-test-table-boy">

            <div></div>
        </div>
    </td>
    <td id="child_29_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_29_8">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_29_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_29_10">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_29_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_29_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">30</td>

    <td id="child_30_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_30_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_30_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_30_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_30_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_30_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_30_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_30_8">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_30_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_30_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_30_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_30_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">31</td>

    <td id="child_31_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_31_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_31_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_31_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_31_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_31_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_31_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_31_8">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_31_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_31_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_31_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_31_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">32</td>

    <td id="child_32_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_32_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_32_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_32_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_32_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_32_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_32_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_32_8">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_32_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_32_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_32_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_32_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">33</td>

    <td id="child_33_1">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_33_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_33_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_33_4">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
    <td id="child_33_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_33_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_33_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_33_8">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_33_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_33_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_33_11">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_33_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-odd">
    <td class="sex-test-table-noborder sex-test-table-blue16">34</td>

    <td id="child_34_1">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_34_2">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>

    </td>
    <td id="child_34_3">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_34_4">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>

        </div>
    </td>
    <td id="child_34_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_34_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_34_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_34_8">

        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_34_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_34_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_34_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_34_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
<tr class="sex-test-table-even">
    <td class="sex-test-table-noborder sex-test-table-blue16">35</td>

    <td id="child_35_1">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_35_2">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td id="child_35_3">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_35_4">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>

        </div>
    </td>
    <td id="child_35_5">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_35_6">
        <div class="sex-test-table-inner  sex-test-table-girl">

            <div></div>
        </div>
    </td>
    <td id="child_35_7">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_35_8">

        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
    <td id="child_35_9">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>

    <td id="child_35_10">
        <div class="sex-test-table-inner  sex-test-table-girl">
            <div></div>
        </div>
    </td>
    <td id="child_35_11">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>

    </td>
    <td class="sex-test-table-last" id="child_35_12">
        <div class="sex-test-table-inner  sex-test-table-boy">
            <div></div>
        </div>
    </td>
</tr>
</tbody>
</table>

</div>