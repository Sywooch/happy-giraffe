<script type="text/javascript">
    var active_step = 1;
    var filled = false;
    var step_result = null;
    var result = new Array();
    var step_count;

    $(function () {
        step_count = 7;
        $('.RadioClass').attr('checked', false);

        $('#next-step-button').click(function () {
            filled = false;
            $('#step' + active_step + ' input').each(function () {
                if ($(this).is(':checked')) {
                    filled = true;
                    step_result = $('#step' + active_step + ' input').index($(this)) + 1;
                }
            });

            if (filled) {
                result.push(step_result);
//                console.log(result);

                if (step_count == active_step)
                    return ShowResult();
                $('#test-inner').animate({left:-active_step * 400}, 500);
                active_step++;
            } else {
                $('.error').show().fadeOut(2000);
            }
            return false;
        });



        $('#step0 .hair_begin').click(function(){
            $('#step0').fadeOut(300, function(){
                $('.h_step_first').fadeIn(300);
            });
            return false;
        });

        $(".RadioClass").change(function(){
            step_result = $('#step' + active_step + ' input').index($(this)) + 1;
            result.push(step_result);

            if (step_count == active_step)
                $('#step' + active_step).fadeOut(300, function(){
                    ShowResult();
                });
            $('#step' + active_step).fadeOut(300, function(){
                $('#step' + active_step).fadeIn(300);
            });
            active_step++;
        });
    });

    function ShowResult() {
        var arr2 = new Array(0, 0, 0, 0, 0, 0);
        for (var i = 0; i <= result.length - 1; i++) {
            arr2[result[i]]++;
        }
        var v1 = arr2[1];
        var v2 = arr2[2];
        var v3 = arr2[3];
        var v4 = arr2[4];

        if (v1 > v2 && v1 > v3 && v1 > v4) {
            $('#normal_type').fadeIn(300);
            return;
        }
        if (v1 > v2 && v1 > v3 && v1 == v4) {
            $('#mixed_type').fadeIn(300);
            return;
        }
        if (v2 > v1 && v2 > v3 && v2 > v4) {
            $('#greasy_type').fadeIn(300);
            return;
        }
        if (v2 > v1 && v2 > v3 && v2 == v4) {
            $('#greasy_type').fadeIn(300);
            return;
        }
        if (v2 == v1 && v2 > v3 && v2 > v4) {
            $('#greasy_type').fadeIn(300);
            return;
        }
        if (v3 > v1 && v3 > v2 && v3 > v4) {
            $('#dry_type').fadeIn(300);
            return;
        }
        if (v3 > v1 && v3 > v2 && v3 == v4) {
            $('#dry_type').fadeIn(300);
            return;
        }
        if (v3 == v1 && v3 > v2 && v3 > v4) {
            $('#dry_type').fadeIn(300);
            return;
        }
        if (v4 > v1 && v4 > v2 && v4 > v3) {
            $('#mixed_type').fadeIn(300);
            return;
        }

        $('#unknown_type').fadeIn(300);
    }
</script>
<div class="error" style="display: none;">
    Выберите вариант
</div>
<div class="hair_type_bl" id="step0">
    <img src="../images/hair_section_main.jpg" alt="" title="" />
    <a href="#" class="hair_begin">Пройти тест</a>
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_first" id="step1" style="display: none;">
    <img src="../images/hair_section_step_first.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Привычная для Вас<br /> частота мытья волос</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value11" class="RadioClass" />
                    <label for="value11" class="RadioLabelClass">1 раз в 2-3 дня</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value12" class="RadioClass"/>
                    <label for="value12" class="RadioLabelClass">Каждый день и чаще</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value13" class="RadioClass"/>
                    <label for="value13" class="RadioLabelClass">1 раз в 6-8 дней и реже</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value14" class="RadioClass"/>
                    <label for="value14" class="RadioLabelClass">1 раз в 3-4 дня</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_second" id="step2" style="display: none;">
    <img src="../images/hair_section_step_second.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Корни волос</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value21"class="RadioClass" />
                    <label for="value21" class="RadioLabelClass">Сразу после мытья нормальные, к концу 2-3-го дня - жирные</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value22" class="RadioClass"/>
                    <label for="value22" class="RadioLabelClass">Сразу после мытья нормальные, к концу первого дня или через несколько часов - жирные</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value23" class="RadioClass"/>
                    <label for="value23" class="RadioLabelClass">Сразу после мытья – сухие, на 3-4 день ближе к нормальным, к концу 7-10-го дня – умеренно жирные</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value24" class="RadioClass"/>
                    <label for="value24" class="RadioLabelClass">Сразу после мытья нормальные, на 2-3 день – жирные корни и все еще сухие концы</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_third" id="step3" style="display: none;">
    <img src="../images/hair_section_step_third.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Кончики волос<br /> (при длине волос более 20-25 см.)</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value31"class="RadioClass" />
                    <label for="value31" class="RadioLabelClass">Нормальные или суховатые; иногда секущиеся</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value32" class="RadioClass"/>
                    <label for="value32" class="RadioLabelClass">Не секутся (или очень редко)</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value33" class="RadioClass"/>
                    <label for="value33" class="RadioLabelClass">Сухие, секущиеся, ломкие, пористые</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value34" class="RadioClass"/>
                    <label for="value34" class="RadioLabelClass">Сухие, секущиеся</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_fourth" id="step4" style="display: none;">
    <img src="../images/hair_section_step_fourth.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Блеск волос<br />(фактор, сильно зависящий от<br />применяемого шампуня)</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value41"class="RadioClass" />
                    <label for="value41" class="RadioLabelClass">Сразу после мытья – чистый блеск, к концу 2-3 дня – у корней «жирный» блеск</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value42" class="RadioClass"/>
                    <label for="value42" class="RadioLabelClass">Сразу после мытья – чистый блеск, к середине первого дня – «жирный» блеск</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value43" class="RadioClass"/>
                    <label for="value43" class="RadioLabelClass">Сразу после мытья – блеск недостаточно интенсивный, хотя и присутствует. Затем тускнеет.</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value44" class="RadioClass"/>
                    <label for="value44" class="RadioLabelClass">Сразу после мытья – чистый блеск у корней, недостаточно интенсивный – на кончиках. Через 3-4 дня – «жирный» блеск у корней и никакого блеска на кончиках.</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_fifth" id="step5" style="display: none;">
    <img src="../images/hair_section_step_fifth.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Электризация</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value51"class="RadioClass" />
                    <label for="value51" class="RadioLabelClass">Очень редко</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value52" class="RadioClass"/>
                    <label for="value52" class="RadioLabelClass">Почти никогда</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value53" class="RadioClass"/>
                    <label for="value53" class="RadioLabelClass">Очень часто</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value54" class="RadioClass"/>
                    <label for="value54" class="RadioLabelClass">Чаще кончики</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_sixth" id="step6" style="display: none;">
    <img src="../images/hair_section_step_sixth.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Пышность</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value61"class="RadioClass" />
                    <label for="value61" class="RadioLabelClass">При прочих равных условиях <br />– удовлетворительная</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value62" class="RadioClass"/>
                    <label for="value62" class="RadioLabelClass">Сразу после мытья – неплохая, <br />затем – «жирные сосульки»</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value63" class="RadioClass"/>
                    <label for="value63" class="RadioLabelClass">Чаще повышенная (волосы разлетаются)</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value64" class="RadioClass"/>
                    <label for="value64" class="RadioLabelClass">У корней – обычная,<br />кончики «разлетаются»</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_seventh" id="step7" style="display: none;">
    <img src="../images/hair_section_step_seventh.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Пористость (способность<br />впитывать и удерживать влагу)<br />- для волос без химии и<br />окрашивания</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value71"class="RadioClass" />
                    <label for="value71" class="RadioLabelClass">Средняя</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value72" class="RadioClass"/>
                    <label for="value72" class="RadioLabelClass">Низкая</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value73" class="RadioClass"/>
                    <label for="value73" class="RadioLabelClass">Высокая (впитывают влагу как губка)</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value74" class="RadioClass"/>
                    <label for="value74" class="RadioLabelClass">У корней низкая, на кончиках – высокая</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="greasy_type" style="display: none;">
    <img src="../images/hair_section_main.jpg" alt="" title="" />
    <div class="hair_result_bl">
        <span class="rs_title">Результат</span>
        <span class="your_res">Тип Ваших волос: <ins>Жирные</ins></span>
        <span class="your_rec">Рекомендации</span>
        <p>Мыть каждый день или через день мягким шампунем для ежедневного мытья, иногда (1 раз в 20-30 дней) используя шампунь для жирных волос. Масками не увлекаться, маслами не пользоваться. Химия, окраска волос рекомендуются. Скорректировать диету в сторону уменьшения потребления жиров и углеводов.</p>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="dry_type" style="display: none;">
    <img src="../images/hair_section_main.jpg" alt="" title="" />
    <div class="hair_result_bl">
        <span class="rs_title">Результат</span>
        <span class="your_res">Тип Ваших волос: <ins>Сухие</ins></span>
        <span class="your_rec">Рекомендации</span>
        <p>Мыть каждый день или через день мягким шампунем для ежедневного мытья, иногда (1 раз в 20-30 дней) используя шампунь для жирных волос. Масками не увлекаться, маслами не пользоваться. Химия, окраска волос рекомендуются. Скорректировать диету в сторону уменьшения потребления жиров и углеводов.</p>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="normal_type" style="display: none;">
    <img src="../images/hair_section_main.jpg" alt="" title="" />
    <div class="hair_result_bl">
        <span class="rs_title">Результат</span>
        <span class="your_res">Тип Ваших волос: <ins>Нормальные</ins></span>
        <span class="your_rec">Рекомендации</span>
        <p>Мыть каждый день или через день мягким шампунем для ежедневного мытья, иногда (1 раз в 20-30 дней) используя шампунь для жирных волос. Масками не увлекаться, маслами не пользоваться. Химия, окраска волос рекомендуются. Скорректировать диету в сторону уменьшения потребления жиров и углеводов.</p>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="mixed_type" style="display: none;">
    <img src="../images/hair_section_main.jpg" alt="" title="" />
    <div class="hair_result_bl">
        <span class="rs_title">Результат</span>
        <span class="your_res">Тип Ваших волос: <ins>Смешанные</ins></span>
        <span class="your_rec">Рекомендации</span>
        <p>Мыть каждый день или через день мягким шампунем для ежедневного мытья, иногда (1 раз в 20-30 дней) используя шампунь для жирных волос. Масками не увлекаться, маслами не пользоваться. Химия, окраска волос рекомендуются. Скорректировать диету в сторону уменьшения потребления жиров и углеводов.</p>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="unknown_type" style="display: none;">
    <img src="../images/hair_section_main.jpg" alt="" title="" />
    <div class="hair_result_bl">
        <span class="rs_title">Результат</span>
        <span class="your_res">Тип Ваших волос: <ins>неизвестен</ins></span>
        <span class="your_rec">Рекомендации</span>
        <p>Мыть каждый день или через день мягким шампунем для ежедневного мытья, иногда (1 раз в 20-30 дней) используя шампунь для жирных волос. Масками не увлекаться, маслами не пользоваться. Химия, окраска волос рекомендуются. Скорректировать диету в сторону уменьшения потребления жиров и углеводов.</p>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->