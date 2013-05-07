<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/bossbirthday.css')
    ;
?>

<div id="content" class="clearfix">

    <div class="clearfix">
        <div class="logo-box">
            <a href="/" class="logo" title="hg.ru – Домашняя страница">Ключевые слова сайта</a>
            <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
        </div>
    </div>

    <div id="bossbirthday-start" class="bossbirthday" style="display:block;">
        <div class="bossbirthday_t">Коллектив Веселого Жирафа поздравляет своего шефа с Днём рождения!</div>
        <div class="bossbirthday_fact bossbirthday_fact__big">
            <p>Крепкого здоровья — чтобы хватило на всё; <br>Много денег — чтобы хватило на всех; <br>И исполнения всех желаний, чтобы <br>освободить место для новых!
                <img src="/images/bossbirthday/bossbirthday1.jpg" alt="">
            </p>
            <!-- Может без указания времени -->
            <div class="bossbirthday_desc">- команда Веселый Жираф, сегодня 08:00</div>

            <div class="margin-t20 clearfix">
                <div class="bossbirthday_test-desc">В этот день мы решили узнать, почему наш проект называется Весёлый Жираф и обнаружили, что у Миры и жирафа много общего!</div>
                <a href="bossbirthday-step1" class="bossbirthday_test js-bossbirthday-step">Пройти сравнительный тест</a>
            </div>
        </div>
    </div>

    <div id="bossbirthday-step1" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare1.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Жираф по латыни cameleopard (camel+leopard), потому что он большой, как верблюд и пятнистый, как леопард. Имя Мира характеризует своего владельца как мирного человека, стремящегося объять весь мир.</p>
            <div class="bossbirthday_desc">- Анастасия, сегодня 08:03</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step2" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox1">
            <label for="bossbirthday_checkbox1" class="bossbirthday_label"></label>
        </div>
    </div>

    <div id="bossbirthday-step2" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare2.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Жираф является самым высоким животным, а Мира отличается грандиозными планами на будущее.</p>
            <div class="bossbirthday_desc">- Никита, сегодня 08:07</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step3" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox2">
            <label for="bossbirthday_checkbox2" class="bossbirthday_label"></label>
            <a href="bossbirthday-step1" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step3" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare3.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>У жирафа самое большое сердце, а у Миры — самое объёмное, в него легко помещаются заботы о своих родных и близких, текущих и будущих проектах, и множестве сотрудниках.</p>
            <div class="bossbirthday_desc">- Александр, сегодня 08:12</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step4" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox3">
            <label for="bossbirthday_checkbox3" class="bossbirthday_label"></label>
            <a href="bossbirthday-step2" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step4" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare4.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Самцы жирафов рычат при поединках, иногда храпят, стонут, шипят и издают звуки, напоминающие флейту. Палитра звуков Миры гораздо шире — об этом хорошо знают те, кто хоть раз побывал у него «на ковре».</p>
            <div class="bossbirthday_desc">- Алексей, сегодня 08:15</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step5" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox4">
            <label for="bossbirthday_checkbox4" class="bossbirthday_label"></label>
            <a href="bossbirthday-step3" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step5" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare5.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Пятна на шкуре жирафа уникальны, так же, как всё, что создаёт Мира на просторах интернета.</p>
            <div class="bossbirthday_desc">- Андрей, сегодня 08:21</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step6" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox5">
            <label for="bossbirthday_checkbox5" class="bossbirthday_label"></label>
            <a href="bossbirthday-step4" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step6" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare6.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Язык жирафа имеет длину около 45 см. Никто не знает длины языка Миры, однако уболтать он может любого!</p>
            <div class="bossbirthday_desc">- Анастасия, сегодня 08:24</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step7" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox6">
            <label for="bossbirthday_checkbox6" class="bossbirthday_label"></label>
            <a href="bossbirthday-step5" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step7" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare7.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Стада жирафов не имеют четкой организации и иерархии. В них могут находиться даже посторонние. У Миры всё наоборот: чёткая структура, конкретная иерархия и никаких посторонних на освоенной территории!</p>
            <div class="bossbirthday_desc">- Александр, сегодня 08:28</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step8" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox7">
            <label for="bossbirthday_checkbox7" class="bossbirthday_label"></label>
            <a href="bossbirthday-step6" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step8" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare8.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Шаг жирафа составляет более 4 метров. Когда он спокойно идет, другим приходится бежать, чтобы не отставать. В этом жираф похож на Миру, который семимильными шагами отрывается от конкурентов.</p>
            <div class="bossbirthday_desc">- Никита, сегодня 08:34</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step9" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox8">
            <label for="bossbirthday_checkbox8" class="bossbirthday_label"></label>
            <a href="bossbirthday-step7" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step9" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare9.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p>Время сна жирафа — не более 10 минут за один раз. Когда спит Мира непонятно, потому что он находится на связи в любое время суток и всегда готов к ответам на любые вопросы.</p>
            <div class="bossbirthday_desc">- Алексей, сегодня 08:36</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step10" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox9">
            <label for="bossbirthday_checkbox9" class="bossbirthday_label"></label>
            <a href="bossbirthday-step8" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step10" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare10.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p> Жирафы выясняют кто из них лидер, используя самую сильную часть своего тела: шею. Мира для утверждения своего лидерства тоже использует самую сильную часть своего тела: мозги.</p>
            <div class="bossbirthday_desc">- Алексей, сегодня 08:44</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-step11" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox10">
            <label for="bossbirthday_checkbox10" class="bossbirthday_label"></label>
            <a href="bossbirthday-step9" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-step11" class="bossbirthday">
        <div class="bossbirthday_compare">
            <img src="/images/bossbirthday/bossbirthday_compare11.jpg" alt="">
        </div>
        <div class="bossbirthday_fact">
            <p> Жираф за всю жизнь не зевает ни разу. Скучающего Миру не видел никто, так как для него есть только одна форма существования — стремительное продвижение вперёд!</p>
            <div class="bossbirthday_desc">- Анастасия, сегодня 08:52</div>
        </div>
        <div class="bossbirthday_row">
            <a href="bossbirthday-finish" class="bossbirthday_next js-bossbirthday-step btn-green btn-h46">Далее</a>
            <input type="checkbox" name="" class="bossbirthday_checkbox" id="bossbirthday_checkbox11">
            <label for="bossbirthday_checkbox11" class="bossbirthday_label"></label>
            <a href="bossbirthday-step10" class="bossbirthday_back js-bossbirthday-step"></a>
        </div>
    </div>

    <div id="bossbirthday-finish" class="bossbirthday">
        <div class="bossbirthday_fact bossbirthday_fact__big">
            <p>Поздравляем! Вы прошли тестирование успешно и можете по праву носить гордое звание отца Весёлого Жирафа и шефа <br>нашего коллектива!	</p>
            <!-- Может без указания времени -->
            <div class="bossbirthday_desc">- команда Веселый Жираф, сегодня 09:00</div>
        </div>
        <div class="bossbirthday_t bossbirthday_t__finish">
            <span class="color-carrot">Мира!</span> <br>
            Поздравляем тебя с Днём рождения! <br>
            Пускай растёт и крепнет мощный траф! <br>
            Мы верим в успех! И имеет значение, <br>
            Что есть в интернете Весёлый Жираф! <br>
        </div>

        <?php
            $this->widget('application.widgets.commentWidget.CommentWidget', array('model' => $mira));
        ?>
    </div>

</div>

<div class="footer-push"></div>

<script type="text/javascript">
    $(function(){
        $('.js-bossbirthday-step').click(function(e){
            itemId = $(this).attr("href");
            $(this).parents(".bossbirthday").fadeOut(300, function () {
                $('#'+itemId).fadeIn(300);
            })
            return false;
        })
    });
</script>