<script type="text/javascript">
    var arr = new Array(
        new Array(new Array(1), new Array(1, 2), new Array(1, 3), new Array(2, 3)),
        new Array(new Array(1, 2), new Array(1, 2), new Array(1, 2, 3, 4), new Array(2, 3, 4)),
        new Array(new Array(1, 3), new Array(1, 2, 3, 4), new Array(1, 3), new Array(2, 3, 4)),
        new Array(new Array(2, 3), new Array(2, 3, 4), new Array(2, 3, 4), new Array(2, 3, 4))
    );

    var father_group = null;
    var mother_group = null;
    var baby_group = null;

    $(function () {
        $('.child_sex_blood_banner input[type=button]').click(function () {
            if (father_group !== null && mother_group !== null) {
                baby_group = arr[father_group-1][mother_group-1];
            }
            ShowBabyBlood();
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
            $('.child_sex_blood_banner input[type=button]').removeClass('calc_grey').addClass('calc_grey_active');
        }
    }

    function ShowBabyBlood() {
        $('#result').html(baby_group.toString());
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

<div id="result"></div>