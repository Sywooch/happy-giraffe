<div class="layout-container">
    <div class="hg-monitor">
        <div class="hg-monitor_in"></div>
    </div>
    <div class="layout-hg-bg">
        <div class="layout-wrapper">

            <div class="layout-thin clearfix">
                <div class="b-avacancy">
                    <?=CHtml::beginForm(array('site/vacancySend'), 'post', array('id' => 'vacancyForm'))?>
                    <div class="hg-about">
                        <div class="hg-about_logo"></div>
                        <div class="hg-about_desc">
                            Веселый Жираф (<a href="http://www.happy-giraffe.ru">www.happy-giraffe.ru</a>) - это социальная сеть для родителей и их детей. Стартовав в 2012 году, Веселый Жираф уже сегодня входит в ТОП-3 крупнейших семейных сайтов русского сегмента интернета с посещаемостью более 4 миллионов пап и мам в месяц. Сегодня мы ищем талантливых и амбициозных сотрудников, чтобы занять лидирующее положение.
                        </div>
                    </div>

                    <h1 class="heading-title">PHP-разработчик</h1>

                    <div class="margin-b40">
                        <div class="title-small">Вам необходимо владеть:</div>
                        <ul class="list-simple">
                            <li class="list-simple_li">отличное знание PHP 5;</li>
                            <li class="list-simple_li">опыт работы с Yii или другим MVC-фреймворком;</li>
                            <li class="list-simple_li">отличное знание JavaScript;</li>
                            <li class="list-simple_li">опыт работы с MySQL, умение писать и оптимизировать сложные запросы и расставлять индексы;</li>
                            <li class="list-simple_li">уверенное пользование системой контроля версий Git;</li>
                            <li class="list-simple_li">UNIX на уровне уверенного пользователя.</li>
                        </ul>
                    </div>

                    <div class="margin-b40">
                        <div class="title-small">Большим плюсом будет:</div>
                        <ul class="list-simple">
                            <li class="list-simple_li">опыт работы с Knockout.js или другим MVVM-фреймворком;</li>
                            <li class="list-simple_li">опыт работы с MongoDB или другой документо-ориентированной СУБД.</li>
                        </ul>
                    </div>

                    <div class="margin-b40">
                        <div class="title-small">Тип занятости</div>
                        <p>Полная занятость, удаленная работа.</p>
                    </div>

                    <div class="margin-b40">
                        <div class="title-small">Уровень заработной платы </div>
                        <p>От 60 000 рублей. Зависит от вашего уровня. Рассмотрим всех кандидатов от <br> просто профессионалов до супер героев.</p>
                    </div>

                    <div class="vote-vacancy">
                        <div class="title-small">Продемонстрируйте свои знания</div>
                        <div class="vote-vacancy_q">
                            <div class="vote-vacancy_l">
                                <div class="vote-vacancy_l-tx">Вопрос 1</div>
                            </div>
                            <div class="vote-vacancy_r">
                                <div class="vote-vacancy_desc">
                                    <p>Напишите программу на PHP, которая выводит на экран числа от 1 до 100. При этом вместо чисел, кратных трем, программа должна выводить слово «Fizz», а вместо чисел, кратных пяти — слово «Buzz». Если число кратно и 3, и 5, то программа должна выводить слово «FizzBuzz».</p>
                                </div>
                                <textarea name="answers[]" cols="30" rows="10" class="itx-gray"></textarea>
                            </div>
                        </div>
                        <div class="vote-vacancy_q">
                            <div class="vote-vacancy_l">
                                <div class="vote-vacancy_l-tx">Вопрос 2</div>
                            </div>
                            <div class="vote-vacancy_r">
                                <div class="vote-vacancy_desc">
                                    <p>Спроектируйте структуру базы данных MySQL для системы обмена сообщениями между пользователями на сайте с учетом следующих требований:</p>
                                    <p>
                                        а) Пользователь может удалить любое (отправленное им самим или собеседником) сообщение в переписке, причем только для себя (у собеседника оно остается нетронутым);</br>
                                        б) пользователь может пометить любой диалог как скрытый (опять же, у собеседника он останется нетронутым);</br>
                                        в) необходимо для каждого сообщения хранить статус прочитанности.
                                    </p>
                                    <p><i class="color-gray b-avacancy_help">Ответ должен содержать список таблиц и их полей, а также индексы.</i></p>
                                </div>
                                <textarea name="answers[]" cols="30" rows="10" class="itx-gray"></textarea>
                            </div>
                        </div>
                        <div class="vote-vacancy_q">
                            <div class="vote-vacancy_l">
                                <div class="vote-vacancy_l-tx">Вопрос 3</div>
                            </div>
                            <div class="vote-vacancy_r">
                                <div class="vote-vacancy_desc">
                                    <p>Напишите функцию, которая принимает в качестве аргументов массив <strong><em>a</em></strong>, индекс одного из его элементов <strong><em>i</em></strong> и число <strong><em>n</em></strong>. Функция должна возвращать массив, состоящий из <strong><em>n</em></strong> элементов, следующих за элементом <strong><em>i</em></strong> в массиве <strong><em>a</em></strong>. Причем если таковых окажется меньше <strong><em>n</em></strong>, недостающие элементы необходимо добрать в начале массива - подразумевается, что после последнего элемента массива следует первый. Доработайте функцию так, чтобы она могла возращать не только следующие, но и предыдущие элементы.</p>
                                    <p>Пример кода:</p>
                                    <div class="vote-vacancy_code">
                                        var a = [10, 20, 30, 40, 50, 60]; <br>
                                        roundSlice(a, 4, 2); <br>
                                    </div>
                                    <p>Результат:</p>
                                    <div class="vote-vacancy_code">
                                        [60, 10] <br>
                                    </div>
                                </div>
                                <textarea name="answers[]" cols="30" rows="10" class="itx-gray"></textarea>
                            </div>
                        </div>
                        <div class="vote-vacancy_q">
                            <div class="vote-vacancy_l">
                                <div class="vote-vacancy_l-tx">Вопрос 4</div>
                            </div>
                            <div class="vote-vacancy_r">
                                <div class="vote-vacancy_desc">
                                    <p>Оцените свои знания следующих технологий по шкале: 0 – не сталкивался, 1 – имею небольшой опыт, 2 – знаю хорошо, 3 – эксперт: </p>
                                    <p>
                                        а) PHP; <br>
                                        б) Yii или другие PHP-фреймворки; <br>
                                        в) язык SQL, MySQL или другой SQL-сервер; <br>
                                        г) NoSQL базы данных; <br>
                                        д) ОС unix/linux, стандартные средства shell; <br>
                                        е) алгоритмы и структуры данных; <br>
                                        ж) JavaScript. <br>
                                    </p>

                                </div>
                                <textarea name="answers[]" cols="30" rows="10" class="itx-gray"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="title-small">Расскажите нам о себе</div>
                    <div class="f-about">
                        <div class="f-about_row clearfix">
                            <div class="f-about_col-l">
                                <lable class="f-about_label">Имя, фамилия</lable>
                            </div>
                            <div class="f-about_col-r">
                                <input type="text" name="name" class="itx-gray w-70p">
                            </div>
                        </div>
                        <div class="f-about_row clearfix">
                            <div class="f-about_col-l">
                                <lable class="f-about_label">E-mail *</lable>
                            </div>
                            <div class="f-about_col-r">
                                <input type="text" name="email" class="itx-gray w-70p">
                            </div>
                        </div>
                        <div class="f-about_row clearfix">
                            <div class="f-about_col-l">
                                <lable class="f-about_label">Ссылка на резюме на HeadHunter</lable>
                            </div>
                            <div class="f-about_col-r">
                                <input type="text" name="hhLink" class="itx-gray">
                            </div>
                        </div>
                        <div class="f-about_row clearfix">
                            <div class="f-about_col-l">
                                <lable class="f-about_label">Ссылка на GitHub</lable>
                            </div>
                            <div class="f-about_col-r">
                                <input type="text" name="githubLink" class="itx-gray">
                            </div>
                        </div>
                        <div class="f-about_row clearfix">
                            <div class="f-about_col-l">
                                <lable class="f-about_label">Skype</lable>
                            </div>
                            <div class="f-about_col-r">
                                <input type="text" name="skype" class="itx-gray w-70p">
                            </div>
                        </div>
                    </div>

                    <div class="textalign-c margin-b10" style="display: none;">
                        <div class="msg-error">Заполните обязательные поля *</div>
                    </div>
                    <div class="textalign-c margin-b70">
                        <a href="javascript:void(0)" class="btn-green btn-large" onclick="processForm(this)">ОТПРАВИТЬ</a>
                    </div>
                    <div class="textalign-c margin-b70" style="display: none;">
                        Спасибо за проявленный интерес к работе в нашей компании.  Мы с вами скоро свяжемся.
                    </div>
                    <div class="textalign-c margin-b70">
                        Вы можете написать нам <a href="mailto:info@happy-giraffe.ru" class="padding-l5">info@happy-giraffe.ru</a>
                    </div>
                    <?php CHtml::endForm(); ?>
                </div>

            </div>

            <a href="#layout" id="btn-up-page"></a>
        </div>
    </div>
    <div class="footer-push"></div>
    <?php $this->renderPartial('//_footer'); ?>
</div>

<script type="text/javascript">
    function processForm(el) {
        var email = $('input[name=email]');
        if (email.val().length > 0) {
            email.parent().removeClass('error');
            $.post($('#vacancyForm').attr('action'), $('#vacancyForm').serialize(), function() {
                $(el).parent().hide();
                $(el).parent().next().show();
                $(el).parent().prev().hide();
            });
        } else {
            email.parent().addClass('error');
            $(el).parent().prev().show();
        }
    }
</script>