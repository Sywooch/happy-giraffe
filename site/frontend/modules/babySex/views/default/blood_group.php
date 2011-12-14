<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<script type="text/javascript">
    var father_group = null;
    var mother_group = null;

    $(function () {
        $('.child_sex_blood_banner input[type=button]').click(function () {
            if (father_group !== null && mother_group !== null) {
                var sum = father_group + mother_group;
                if (sum % 2 == 0) {
                    $('.wh_son').hide();
                    $('.wh_daughter').show();
                } else {
                    $('.wh_daughter').hide();
                    $('.wh_son').show();
                }
            }
            return false;
        });

        $('.man_bl ul li a').click(function () {
            $('.man_bl ul li a').removeClass('active');
            $(this).addClass('active');
            father_group = $('.man_bl ul li a').index($(this)) + 1;
            CheckButtonEnable();
            return false;
        });

        $('.woman_bl ul li a').click(function () {
            $('.woman_bl ul li a').removeClass('active');
            $(this).addClass('active');
            mother_group = $('.woman_bl ul li a').index($(this)) + 1;
            CheckButtonEnable();
            return false;
        });
    });

    function CheckButtonEnable() {
        if (father_group !== null && mother_group !== null) {
//            $('.child_sex_blood_banner input[type=button]').removeClass('calc_grey').addClass('calc_bt');
        }
    }
</script>

<div class="child_sex_blood_banner">
    <form action="">
        <div class="man_blood">II Rh(+)</div>
        <!-- .man_blood -->
        <div class="woman_blood">I Rh(-)</div>
        <!-- .woman_blood -->
        <div class="gr_bl man_bl">
            <span>Группа крови отца:</span>

            <div class="ch_group">
                <ul>
                    <li><a href="#">I</a></li>
                    <li><a href="#">II</a></li>
                    <li><a href="#">III</a></li>
                    <li><a href="#">IV</a></li>
                </ul>
                <?php echo CHtml::hiddenField('father_blood_group', '', array('id' => 'father_blood_group')) ?>
            </div>
            <!-- .ch_group -->
        </div>
        <!-- .gr_bl -->
        <div class="gr_bl woman_bl">
            <span>Группа крови матери:</span>

            <div class="ch_group">
                <ul>
                    <li><a href="#">I</a></li>
                    <li><a href="#">II</a></li>
                    <li><a href="#">III</a></li>
                    <li><a href="#">IV</a></li>
                </ul>
                <?php echo CHtml::hiddenField('mother_blood_group', '', array('id' => 'mother_blood_group')) ?>
            </div>
            <!-- .ch_group -->
        </div>
        <!-- .gr_bl -->
        <input type="button" class="calc_grey" value="Рассчитать"/>
    </form>
</div><!-- .child_sex_blood_banner -->

<div class="wh_wait wh_daughter" style="display: none;">
    <span class="title_wh_wait">У Вас будет дочь</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил
        постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно.</p>
</div><!-- .wh_wait -->

<div class="wh_wait wh_son" style="display: none;">
    <span class="title_wh_wait">У Вас будет сын</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил
        постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно.</p>
</div><!-- .wh_wait -->