<script type="text/javascript">
    var arr = new Array(
        new Array(1, new Array(1, 2), new Array(1, 3), new Array(2, 3)),
        new Array(new Array(1, 2), new Array(1, 2), new Array(1, 2, 3, 4), new Array(2, 3, 4)),
        new Array(new Array(1, 3), new Array(1, 2, 3, 4), new Array(1, 3), new Array(2, 3, 4)),
        new Array(new Array(2, 3), new Array(2, 3, 4), new Array(2, 3, 4), new Array(2, 3, 4))
    );

    var father_group = null;
    var mother_group = null;
    var baby_group = null;

    $(function () {
        $('.baby_blood_parent_group_u input[type=button]').click(function () {
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
            $('.baby_blood_parent_group input[type=button]').removeClass('calc_grey').addClass('calc_grey_active');
        }
    }

    function ShowBabyBlood() {
        $('.result_bl').show();
        if (baby_group instanceof Array)
            $('.baby_blood_result').html(GetResultString(baby_group));
        else
            $('.baby_blood_result').html(ToRoman(baby_group));
    }

    function ToRoman(digit){
        if (digit == 1) return 'I';
        if (digit == 2) return 'II';
        if (digit == 3) return 'III';
        if (digit == 4) return 'IV';
        return 'error';
    }

    function GetResultString(group){
        var or_position = group.length - 2;

        var result = '';
        for(var i = 0; i < group.length; i++){
            if (i == or_position)
                result += ToRoman(group[i])+' <ins>или</ins> ';
            else{
                if (i == group.length-1)
                    result += ToRoman(group[i]);
                else
                    result += ToRoman(group[i])+', ';
            }
        }
        return result;
    }
</script>

<div class="baby_blood_parent_group">
    <form action="">
        <ul class="baby_blood_parent_group_u">
            <li>
                <div class="gr_bl">
                    <div class="ch_group man_bl">
                        <span>Группа крови отца:</span>
                        <ul>
                            <li><a href="#">I</a></li>
                            <li><a href="#">II</a></li>
                            <li><a href="#">III</a></li>
                            <li><a href="#">IV</a></li>
                        </ul>
                    </div><!-- .ch_group -->
                </div><!-- .gr_bl -->
            </li>
            <li>
                <div class="gr_bl">
                    <div class="ch_group woman_bl">
                        <span>Группа крови матери:</span>
                        <ul>
                            <li><a href="#">I</a></li>
                            <li><a href="#">II</a></li>
                            <li><a href="#">III</a></li>
                            <li><a href="#">IV</a></li>
                        </ul>
                    </div><!-- .ch_group -->
                </div><!-- .gr_bl -->
            </li>
            <li>
                <input type="button" class="calc_grey" value="Рассчитать" />
            </li>
            <li>
                <div class="gr_bl result_bl" style="display: none;">
                    <div class="ch_group">
                        <span>Группа крови ребёнка:</span>
                        <span class="baby_blood_result"></span>
                    </div><!-- .ch_group -->
                </div><!-- .gr_bl -->
            </li>
        </ul>
    </form>
</div><!-- .baby_blood_parent_group -->