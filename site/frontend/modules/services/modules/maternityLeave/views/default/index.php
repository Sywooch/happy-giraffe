<?php $this->meta_description = 'Как точно рассчитать декретный отпуск, сроки которого строго определены, но индивидуальны для каждой женщины? Предлагаем вам сделать расчет декрета при помощи нашего сервиса и узнать точно, когда можно оставить свое рабочее место';
?>
<div class="col-white-hoar">
    <div id="baby">
        <div id="decree-time">

            <div class="form">

                <div class="title">
                    <h1>Когда уходить в декрет?</h1>
                    <span>Рассчитаем вместе</span>
                </div>

                <div class="form-in">

                    <div class="row">
                        <div class="row-title">ПДР <span>(предполагаемая дата родов)</span></div>
                        <div class="row-elements">
                            <div class="select-box">
                                <select class="chzn" style="width:60px;" id="day">
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                &nbsp;
                                <select class="chzn" style="width:120px;" id="month">
                                    <option value="0">Январь</option>
                                    <option value="1">Февраль</option>
                                    <option value="2">Март</option>
                                    <option value="3">Апрель</option>
                                    <option value="4">Май</option>
                                    <option value="5">Июнь</option>
                                    <option value="6">Июль</option>
                                    <option value="7">Август</option>
                                    <option value="8">Сентябрь</option>
                                    <option value="9">Октябрь</option>
                                    <option value="10">Ноябрь</option>
                                    <option value="11">Декабрь</option>
                                </select>
                                &nbsp;
                                <select class="chzn" style="width:80px;" id="year">
                                    <?php
                                    for ($i = date('Y'); $i <= (date('Y') + 2); $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="row pregnancy-type">
                        <div class="row-title">Сколько малышей должно появиться на свет?</div>
                        <div class="row-elements">

                            <label><i class="icon-type-1"></i><br/><input type="radio" name="mult-pregnancy" value="0"/> один</label>
                            <label><i class="icon-type-2"></i><br/><input type="radio" name="mult-pregnancy" value="1"/> больше одного</label>
                        </div>
                    </div>

                    <div class="row rest">
                        <div class="row-title">Остаток отпуска <span><input type="text" id="vacation"/> дней</span></div>
                    </div>

                    <div class="row row-btn">
                        <button onclick="MaternityLeave.Calculate(); return false;">Рассчитать</button>
                    </div>

                </div>

            </div>

            <div class="recommendation clearfix" style="display: none;">

                <div class="left">
                    <img src="/images/decree_time_calendar.png"/> <span>14 июня</span>
                </div>

                <div class="right">
                    <big>Рекомендации:</big>

                    <p>С этой даты вы имеете полное право оставить своё рабочее место на законных основаниях, подав заявление на декретный или очередной трудовой отпуск.</p>
                </div>

            </div>

            <div class="wysiwyg-content margin-20">
                <h2 class="h2-services">Сервис «Когда уходить в декрет»</h2>

                <p>Уход в декретный отпуск – желанная финишная ленточка для будущей мамы. Начиная с третьего триместра женщины, ожидающие ребенка, берут в руки календарь и начинают проводить расчет декретного отпуска – подсчитывать, сколько же дней осталось до выхода в декрет.</p>

                <div class="brushed">
                    <p>Теперь можно легко узнать об этом, воспользовавшись нашим сервисом. Всё, что нужно знать, – это предполагаемая дата родов (ПДР); количество деток, которые должны появиться в результате этой беременности; наличие у вас неиспользованных дней очередного трудового отпуска.</p>
                </div>
                <p>ПДР рассчитывается акушером-гинекологом в самом начале беременности по первому дню последней менструации и данным ультразвукового исследования.</p>
                <p>Сколько детей вы носите под сердцем, становится известно после первого или второго УЗИ.</p>
                <p>Сколько дней неиспользованного трудового отпуска у вас имеется, знает бухгалтер той организации, где вы работаете.</p>

                <p>Теперь можно ввести имеющиеся у вас данные в соответствующие окошки и узнать дату, начиная с которой вы имеете полное право оставить своё рабочее место. При этом сначала вы расходуете неиспользованные дни очередного трудового отпуска, а потом пишете заявление на декретный отпуск.</p>

                <p>Расчет декретного отпуска проводится исходя из того, что он даётся на срок:</p>
                <ul>
                <li>140 дней при одноплодной беременности и нормальных родах (70 дней до родов и 70 дней после родов).</li>
                <li>156 дней при одноплодной беременности и осложненных родах (70 дней до родов и 86 дней после родов).</li>
                <li>194 дня при многоплодной беременности (84 дня до родов и 110 после родов).</li>
                </ul>

                <p>Если роды наступили позже рассчитанной даты, в результате чего вы «перебрали» дни дородовой части декретного отпуска, послеродовая часть не сокращается, то есть общая продолжительность декретного отпуска окажется больше.</p>

                <p>Если роды наступили раньше рассчитанной даты, в результате чего вы «недобрали» дни дородовой части декретного отпуска, послеродовая часть увеличивается, так как общая продолжительность декретного отпуска не может быть меньше установленной законом.</p>
                <p>Неизрасходованные дни очередного трудового отпуска вы можете потратить как до того, как начнётся декретный отпуск, так и после его окончания.</p>

                <p>Вот так несложно сделать расчет декретного отпуска самостоятельно.</p>
                <p>Но самое главное: уход в декретный отпуск – ваше личное дело, и заветную дату определяете именно вы!</p>

            </div>

        </div>
    </div>
</div>