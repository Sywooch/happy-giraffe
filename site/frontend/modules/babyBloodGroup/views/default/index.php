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
                baby_group = arr[father_group - 1][mother_group - 1];
            } else
                return false;
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

    function ToRoman(digit) {
        if (digit == 1) return 'I';
        if (digit == 2) return 'II';
        if (digit == 3) return 'III';
        if (digit == 4) return 'IV';
        return 'error';
    }

    function GetResultString(group) {
        var or_position = group.length - 2;

        var result = '';
        for (var i = 0; i < group.length; i++) {
            if (i == or_position)
                result += ToRoman(group[i]) + ' <ins>или</ins> ';
            else {
                if (i == group.length - 1)
                    result += ToRoman(group[i]);
                else
                    result += ToRoman(group[i]) + ', ';
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
                    </div>
                    <!-- .ch_group -->
                </div>
                <!-- .gr_bl -->
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
                    </div>
                    <!-- .ch_group -->
                </div>
                <!-- .gr_bl -->
            </li>
            <li>
                <input type="button" class="calc_grey" value="Рассчитать"/>
            </li>
            <li>
                <div class="gr_bl result_bl" style="display: none;">
                    <div class="ch_group">
                        <span>Группа крови ребёнка:</span>
                        <span class="baby_blood_result"></span>
                    </div>
                    <!-- .ch_group -->
                </div>
                <!-- .gr_bl -->
            </li>
        </ul>
    </form>
</div><!-- .baby_blood_parent_group -->

<div class="seo-text" style="display: none;">
    <h1 class="summary-title">Определение группы крови ребёнка по группам крови его родителей</h1>

    <p>Кроме паспортных данных, веса и роста, каждый человек, обычно, знает ещё и свою группу крови. Группа крови
        наследуется ребёнком от родителей, согласно законам Грегора Менделя. Каким образом это происходит?</p>

    <p>Известно, что в крови человека находятся специфические белковые образования: в плазме – агглютинины, а в
        эритроцитах – агглютиногены. Существуют варианты содержания этих белков в крови человека. В плазме может не быть
        агглютиногенов, определяться только α, только β, или сразу оба α и β. В эритроцитах может не быть
        агглютиногенов, определяться только А, только В, или сразу оба А и В. Известно, что белки α и А у одного и того
        же человека в крови не встречаются, то же самое – в отношении белков β и В.</p>

    <p>То есть, возможных комбинаций белков всего четыре:</p>

    <ul>
        <li>Первая: в плазме агглютинины α и β, в эритроцитах нет агглютиногенов.</li>
        <li>Вторая: в плазме агглютинин β, в эритроцитах агглютиноген А.</li>
        <li>Третья: в плазме агглютинин α, в эритроцитах агглютиноген В.</li>
        <li>Четвёртая: в плазме нет агглютининов, в эритроцитах агглютиногены А и В.</li>
    </ul>

    <p>Именно так люди разделяются по группам крови. Самой распространённой группой крови в России является вторая. Чуть
        реже встречается первая, ещё реже – третья. Четвёртая группа крови встречается реже всех.</p>

    <p>По статистике, люди с первой группой крови чаще имеют заболевания пищеварительного тракта. Обладатели второй
        группы крови чаще других страдают аллергиями, бронхиальной астмой, сахарным диабетом и ревматизмом. Люди,
        имеющие третью группу крови, склонны к пневмониям и заболеваниям нервной системы. А те, кому посчастливилось
        иметь четвёртую группу крови, чаще других болеют вирусными инфекциями.</p>

    <p>Посчитать, какая группа крови будет у ребёнка достаточно просто, воспользовавшись законами Менделя.</p>

    <div class="brushed"><p>Если вам не хочется вспоминать эти законы и решать задачку по генетике – воспользуйтесь нашим
        сервисом. Просто нажмите на кнопки, которые соответствуют группе крови отца и матери ребёнка, и сразу узнайте,
        какая группа крови может быть у малыша.</p></div>


</div>