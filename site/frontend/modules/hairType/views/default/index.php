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

        $('.hair_type_bl').show();
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
            <span class="h_question_title">Как часто вы моете волосы?</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value11" class="RadioClass" />
                    <label for="value11" class="RadioLabelClass">1 раз в 2-3 дня</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value12" class="RadioClass"/>
                    <label for="value12" class="RadioLabelClass">Ежедневно</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value13" class="RadioClass"/>
                    <label for="value13" class="RadioLabelClass">1 раз в неделю или реже</label>
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
            <span class="h_question_title">Ваши корни волос…</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value21"class="RadioClass" />
                    <label for="value21" class="RadioLabelClass">После мытья нормальные, но через день-два становятся жирными и сальными</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value22" class="RadioClass"/>
                    <label for="value22" class="RadioLabelClass">После мытья корни нормальные, но уже к вечеру выглядят жирными и неопрятными</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value23" class="RadioClass"/>
                    <label for="value23" class="RadioLabelClass">После мытья корни сухие, через несколько дней состояние нормализуется, через неделю волосы у корней немного жирные</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value24" class="RadioClass"/>
                    <label for="value24" class="RadioLabelClass">После мытья корни волос нормальные, через 2-3 дня корни становятся жирными, а кончики волос остаются сухими</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_third" id="step3" style="display: none;">
    <img src="../images/hair_section_step_third.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Состояние кончиков ваших волос<br>
            (если длина волос 20-25 см)
            </span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value31"class="RadioClass" />
                    <label for="value31" class="RadioLabelClass">Обычные или немного суховатые, иногда секутся</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value32" class="RadioClass"/>
                    <label for="value32" class="RadioLabelClass">Обычные, в основном не секутся</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value33" class="RadioClass"/>
                    <label for="value33" class="RadioLabelClass">Тонкие и ломкие, часто секутся</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value34" class="RadioClass"/>
                    <label for="value34" class="RadioLabelClass">Тонкие, секущиеся и сухие</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_fourth" id="step4" style="display: none;">
    <img src="../images/hair_section_step_fourth.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Естественный блеск ваших волос<br />  (сразу после мытья)</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value41"class="RadioClass" />
                    <label for="value41" class="RadioLabelClass">После мытья блестят, через пару дней у корней появляется жирный блеск</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value42" class="RadioClass"/>
                    <label for="value42" class="RadioLabelClass">Сразу после мытья блеск натуральный, но уже через несколько часов появляется избыточный жирный блеск</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value43" class="RadioClass"/>
                    <label for="value43" class="RadioLabelClass">После мытья волосы немного блестят, но быстро тускнеют</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value44" class="RadioClass"/>
                    <label for="value44" class="RadioLabelClass">После мытья у корней волосы блестят, на кончиках блеск не такой интенсивный. Через пару дней корни жирные, а кончики не блестят</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_fifth" id="step5" style="display: none;">
    <img src="../images/hair_section_step_fifth.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Электризуются ли ваши волосы?</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value51"class="RadioClass" />
                    <label for="value51" class="RadioLabelClass">Весьма редко</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value52" class="RadioClass"/>
                    <label for="value52" class="RadioLabelClass">Практически никогда</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value53" class="RadioClass"/>
                    <label for="value53" class="RadioLabelClass">Достаточно регулярно</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value54" class="RadioClass"/>
                    <label for="value54" class="RadioLabelClass">В основном кончики волос</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_sixth" id="step6" style="display: none;">
    <img src="../images/hair_section_step_sixth.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Объем ваших волос</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value61"class="RadioClass" />
                    <label for="value61" class="RadioLabelClass">Нормальный</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value62" class="RadioClass"/>
                    <label for="value62" class="RadioLabelClass">После мытья объем есть, но держится недолго</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value63" class="RadioClass"/>
                    <label for="value63" class="RadioLabelClass">Непостоянный, волосы разлетаются</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value64" class="RadioClass"/>
                    <label for="value64" class="RadioLabelClass">Объем только у кончиков волос</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl h_step_seventh" id="step7" style="display: none;">
    <img src="../images/hair_section_step_seventh.jpg" alt="" title="" />
    <div class="hair_inner_bl">
        <form action="">
            <span class="h_question_title">Насколько хорошо ваши волосы <br> впитывают влагу?</span>
            <ul>
                <li>
                    <input type="radio" name="v" id="value71"class="RadioClass" />
                    <label for="value71" class="RadioLabelClass">Средне</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value72" class="RadioClass"/>
                    <label for="value72" class="RadioLabelClass">Плохо</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value73" class="RadioClass"/>
                    <label for="value73" class="RadioLabelClass">Отлично</label>
                </li>
                <li>
                    <input type="radio" name="v" id="value74" class="RadioClass"/>
                    <label for="value74" class="RadioLabelClass">У корней впитываемость хорошая, на кончиках - хуже</label>
                </li>
            </ul>
        </form>
    </div><!-- .hair_inner_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="greasy_type" style="display: none;">
    <img src="../images/hair_section_result.jpg" alt="" title="" />
    <div class="hair_result_bl">
        <span class="your_res">Тип Ваших волос: <ins>Жирные</ins></span>
        <span class="your_rec">Рекомендации</span>
        <ul style="list-style-type: decimal;">
            <li>Мойте волосы по мере их загрязнения. Не слушайте советы тех, кто ратует за мытье раз в неделю. Представьте, как вы будете выглядеть с копной жирных, лоснящихся волос.</li>
            <li>Используйте теплую или прохладную воду, она ослабит работу сальных желез.</li>
            <li>Пользуйтесь только теми шампунями, которые подходят к вашему типу волос. Они содержат активные лечебные вещества, которое положительно повлияют на структуру и внешний вид волос.</li>
            <li>Для жирных волос существуют специальные бальзамы и кондиционеры, они не утяжеляют волосы и не позволяют им быстро засаливаться.</li>
            <li>Можно использовать и проверенные временем народные рецепты. Настой из перечной мяты или крапивы поможет обрести волосам здоровый блеск и пышность.</li>
            <li>Ни в коем случае не сушите волосы горячим феном.</li>
            <li>Расчесывайте волосы расческой с редкими крупными зубцами.</li>
        </ul>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="dry_type" style="display: none;">
    <img src="../images/hair_section_result.jpg" alt="" title="" />
    <div class="hair_result_bl">
        
        <span class="your_res">Тип Ваших волос: <ins>Сухие</ins></span>
        <span class="your_rec">Рекомендации</span>
        <ul style="list-style-type: decimal;">
            <li>Укрепляющие и увлажняющие препараты с витаминами группы В и С и кератиновым комплексом помогут восстановить сухие и ломкие волосы.</li>
            <li>Полезно использовать специальные масла для волос. Репейное, кукурузное, миндальное, оливковое или кокосовое масло нежно втирайте массажными движениями в кожу головы. По истечении 30 минут тщательно промойте волосы.</li>
            <li>На ночь можно намазать волосы миндальным маслом, а непосредственно перед мытьем можно использовать теплое оливковое масло.</li>
            <li>Не мойте голову горячей водой.</li>
            <li>Используйте шампуни и ополаскиватели специально для вашего типа волос.</li>
            <li>Сухие волосы полезно часто расчесывать. Массажный эффект стимулирует выработку кожного жира. Расческу нужно брать смешанного образца, чтобы в ней присутствовали как пластмассовые, так и натуральные зубья.</li>
        </ul>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="normal_type" style="display: none;">
    <img src="../images/hair_section_result.jpg" alt="" title="" />
    <div class="hair_result_bl">
        
        <span class="your_res">Тип Ваших волос: <ins>Нормальные</ins></span>
        <span class="your_rec">Рекомендации</span>
        <ul style="list-style-type: decimal;">
            <li>При мытье головы не наливайте шампунь прямо на волосы, налейте сначала на руку и разбавьте его водой, а потом уже наносите.</li>
            <li>Лучше всего мыть волосы теплой или прохладной водой. Горячая вода может спровоцировать излишнее жировое выделение.</li>
            <li>Волосы светлых оттенков после мытья можно ополаскивать отваром ромашки. Темные волосы можно ополоснуть настоем чая. Такое ополаскивание придаст волосам естественный, шелковистый блеск.</li>
            <li>Можно для ополаскивания использовать и отвары из крапивы или листьев лопуха, нужно просто залить траву кипятком и настоять 10-15 минут.</li>
            <li>Прибавят здоровья волосам и кисломолочные обертывания. Они укрепляют корни волос. Намажьте волосы кефиром, сверху наденьте шапочку и оберните голову теплым полотенцем. Через 25-30 минут просто смойте обычной водой.</li>
        </ul>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="mixed_type" style="display: none;">
    <img src="../images/hair_section_result.jpg" alt="" title="" />
    <div class="hair_result_bl">
        
        <span class="your_res">Тип Ваших волос: <ins>Смешанный</ins></span>
        <span class="your_rec">Рекомендации</span>
        <ul style="list-style-type: decimal;">
            <li>Применяйте только профессиональные средства для ухода. Шампунь, бальзам или тоник – все средства должны быть предназначены только для волос вашего типа. Они содержат те компоненты, которые будут ухаживать именно за вашими волосами. В их состав могут входить пироктон, салициловая кислота, сера или деготь.</li>
            <li>Хороший эффект дают специальные тоники, которые наносятся на волосы и не смываются. Они содержат кератиновый комплекс, который заботится о волосах.</li>
            <li>В домашних условиях можно делать маски из настоя корня алтея, семян льна и крапивы. Травы заваривают в термосе, смешивают с бесцветной хной и не смывают в течение часа. После моют волосы шампунем и в качестве ополаскивателя используют минеральную газированную воду или кипяченую воду, в которую добавлен сок лимона.</li>
            <li>Питательная маска из подорожника, цветков ромашки, листьев шалфея, крапивы и ржаного хлеба поможет вашим волосам восстановить структуру и придать им объем и блеск.</li>
        </ul>
    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->

<div class="hair_type_bl" id="unknown_type" style="display: none;">
    <img src="../images/hair_section_result.jpg" alt="" title="" />
    <div class="hair_result_bl">
        
        <span class="your_res">Тип Ваших волос: <ins>Неизвестен</ins></span>
        <span class="your_rec">Рекомендации</span>

        <p>Похоже, что вы некорректно ответили на поставленные вопросы, поэтому ваш результат определить затруднительно.</p>
        <p>Попробуйте более обдуманно ответить на все вопросы системы, и тогда вы сможете получить грамотные рекомендации по поводу ухода за своими волосами в зависимости от того, к какому типу они относятся.</p>
        <p>Вернитесь к началу теста, сконцентрируйтесь и попробуйте еще раз.</p>

    </div><!-- .hair_result_bl -->
</div><!-- .hair_type_bl -->