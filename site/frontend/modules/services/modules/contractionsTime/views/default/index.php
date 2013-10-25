<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
if (empty($this->meta_description))
    $this->meta_description = 'Это схватки или нет? Может быть, уже пора в родильное отделение? Без паники! Наша схваткосчиталка поможет вам чётко сориентироваться в этом вопросе. Всё, что нужно, – отмечать начало и окончание каждой схватки. Несколько минут – и всё ясно!';
?>
<div class="col-white-hoar">
    <div id="baby">
        <div class="contractions-time-banner">
            <h1 class="contractions-time-banner_t">
                <div class="contractions-time-banner_name">СХВАТКИ-СЧИТАЛКА</div>
                А не пора ли нам в роддом?
            </h1>
        </div>

        <div class="contractions-form">
            <button id="start-count">Старт!</button>
            <div class="time" id="timer">00:00</div>
        </div>

        <div class="contractions-summary">
            <table class="result-table contractions-data">
                <colgroup>
                    <col width="20" />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col width="100" />
                </colgroup>
                <thead>
                    <tr>
                        <td></td>
                        <td>№<br/>схватки</td>
                        <td>Время<br/>начала</td>
                        <td>Время<br/>окончания</td>
                        <td>Длительность<br/>схватки</td>
                        <td>Время между<br/>схватками</td>
                        <td></td>
                    </tr>
                </thead>

                <tbody>
                </tbody>

                <tfoot>
                    <tr id="contractions-remain">
                        <td></td>
                        <td colspan="5"><big>После 5-ой схватки, Вы узнаете результат!</big></td>
                        <td></td>
                    </tr>
                </tfoot>

            </table>

            <center><a class="to-contractions-info" href="#" style="display: none;">Рекомендации</a></center>

            <div class="block-in contractions-data wysiwyg-content magin-20">

                <h2 class="h2-services">Считаем схватки</h2>

                <p>У беременных женщин вопросов много. Оно и понятно, ведь беременность - состояние непривычное, необычное, а ответственность на женщине лежит большая &ndash; выносить и родить здорового малыша.</p>
                <p>Чем ближе к родам, тем больше становится вопросов. И конечно, самые актуальные из них: как распознать схватки, когда ехать в роддом, как не опоздать, как не запаниковать перед схватками?</p>
                <p>Уже перечитана вся литература по этому поводу&hellip; Уже выяснены все моменты, касающиеся настоящих и возможных ложных схваток&hellip; Уже выслушаны все советы мамы и подруг&hellip; Но все равно беспокойство остается &ndash; &laquo;а вдруг&raquo;, &laquo;а что&raquo;, &laquo;а как&raquo;&hellip; Иногда женщина настолько волнуется, что это даже может отразиться на ее состоянии.</p>

                <div class="brushed">
                <h3>Успокойтесь и доверьтесь нашей системе счета схваток</h3>

                <h4>Что это такое?</h4>
                <p>Это автоматическая система, которая, фиксируя начало и конец ваших схваток, будет вести их статистику и тем самым подскажет, когда ехать в роддом. Статистика очень важна &ndash; по ней врач сможет узнать множество нюансов и вести ваши роды максимально точно.</p>

                <h4>Как работает система?</h4>
                <p>Как только у вас начинается схватка, жмите кнопку &laquo;Старт!&raquo;. Это можно сделать как клавишей компьютерной мыши, так и клавиатурной Enter. Пока вы ощущаете схватку, идет счет. Как только схватка заканчивается, вы нажимаете на клавишу &laquo;Финиш&raquo;, и счет останавливается.</p>
                <p>Уже после пяти схваток вы сможете определить, есть ли в них последовательность &ndash; регулярны ли они, идут ли в одинаковые промежутки времени, насколько они длительны и т.д. Вы сразу поймете, истинные это (и пора собираться в роддом) или ложные схватки (можно еще подождать дома).</p>
                <p>Вы также поймете, как быстро вам стоит собираться в роддом. Об этом подскажут графы &laquo;Длительность&raquo; и &laquo;Промежуток между схватками&raquo;. Если длительность все больше, а промежуток все меньше &ndash; значит, уже пора. Если длительность и промежуток не имеют последовательности &ndash; значит, пока рано.</p>

                <h4>Мы уверены: система будет вам полезна!</h4>
                </div>
                <p>Вы должны знать некоторые особенности:</p>
                <ul>
                    <li>Схватка &ndash; это не боль в животе. Вполне может случиться так, что у вас будет болеть не живот, а поясница. Это зависит от положения плода и от физиологических особенностей женщины. Главное свойство схватки &ndash; повторение. Если боли (в спине, в животе, тянущие, ноющие и т.п.) повторяются &ndash; фиксируйте и ведите статистику.</li>
                    <li>Если у вас отошли воды или появилось кровотечение, не тратьте время на ведение статистики &ndash; в роддом следует ехать незамедлительно!</li>
                    <li>Перед схватками, в промежутке между ними не ждите очередной схватки. Это время дается женщине на отдых. Если вы будете напряженно ждать очередной, вы быстро устанете. А ведь главное &ndash; роды &ndash; еще впереди!</li>
                </ul>

            </div>

            <div class="block-in contractions-result contractions-result-1" style="display: none;">

                <div class="box-left">
                    <div class="result-text" style="margin-top:40px;">
                        Подход к начальной фазе, либо ложные схватки
                    </div>
                </div>
                <div class="box-main">
                    <div class="summary-title">Рекомендации:</div>
                    <p>Есть две интепретации этого значения: либо вы приближаетесь к начальной стадии схваток, либо к вам пожаловали предвестники – ложные схватки.</p>
                    <p>Что делать?</p>
                    <p>Главное - не паникуйте. Если есть возможность, свяжитесь с врачом, если нет – спокойно подождите. Если схватки станут больше 30 секунд, а интервал «устаканится» и будет показывать значение 4-5 минут, значит, вы в родах. Если же схватки будут продолжаться так же, как и начались, или вообще прекратятся (такое тоже бывает), значит, пока рано готовиться в роддом.</p>

                    <br/>
                    <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                </div>

            </div>

                <div class="block-in contractions-result contractions-result-2" style="display: none;">
                    <div class="box-left">
                        <div class="result-text" style="margin-top:40px;">
                            Подход к начальной фазе, либо ложные схватки
                        </div>
                    </div>
                    <div class="box-main">
                        <div class="summary-title">Рекомендации:</div>
                        <p>Это неоднозначная ситуация, свидетельствующая либо о приближении начального периода схваток, либо о так называемых «ложных» схватках. Подождите до момента, когда ситуация станет более ясной и точной. Следите за схватками внимательней!</p>
                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                    </div>
                </div>

                <div class="block-in contractions-result contractions-result-3" style="display: none;">
                    <div class="box-left">
                        <div class="result-text">
                            <img src="/images/img_contractions_result_01.jpg"><br>
                            Собирайтесь в<br>роддом!
                        </div>
                    </div>
                    <div class="box-main">
                        <div class="summary-title">Рекомендации:</div>
                        <p>Раскрытие шейки матки находится на уровне 0-3 см.</p>
                        <p>Что это значит?</p>
                        <p>В роддом пока рано. Но вы уже можете начать собираться. Не торопитесь. Ваши роды состоятся через 7-8 часов. Значит, из дома надо будет выехать через 4-5 часов.</p>

                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                        </div>
                </div>

                <div class="block-in contractions-result contractions-result-4" style="display: none;">
                    <div class="box-left">
                        <div class="result-text">
                            <img src="/images/img_contractions_result_01.jpg"><br>
                            Собирайтесь в<br>роддом!
                        </div>
                    </div>
                    <div class="box-main">
                    <div class="summary-title">Рекомендации:</div>
                        <p>Раскрытие шейки составляет 3-7 см. Вы – в активной стадии.</p>
                        <p>Что это значит?</p>
                        <p>Пора ехать в роддом. Вызывайте скорую, такси – как вы планировали, и езжайте! Уже через 3-5 часов вы возьмете на руки своего малыша, появившегося на свет.</p>
                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                    </div>
                </div>

                <div class="block-in contractions-result contractions-result-5" style="display: none;">
                    <div class="box-left">
                        <div class="result-text">
                            <img src="/images/img_contractions_result_01.jpg"><br>
                            Собирайтесь в<br>роддом!
                        </div>
                    </div>
                    <div class="box-main">
                    <div class="summary-title">Рекомендации:</div>
                        <p>Раскрытие шейки уже достигло 7-10 см. Вы в переходной стадии – совсем скоро начнутся роды.</p>
                        <p>Что это значит?</p>
                        <p>Осталось ждать совсем немного. Через полчаса–полтора часа вы родите. Сейчас схватки очень болезненны, но вы справитесь! И станете счастливой мамой! Удачи вам!</p>
                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                    </div>
                </div>

                <div class="block-in contractions-result contractions-result-6" style="display: none;">
                    <div class="box-left">
                        <div class="result-text">
                            <img src="/images/img_contractions_result_04.jpg"><br>
                            Вы рожаете!<br>
                            Срочно вызывайте<br>
                            СКОРУЮ!
                        </div>
                    </div>
                    <div class="box-main">
                        <div class="summary-title">Рекомендации:</div>
                        <p>Вы рожаете! И вы еще у компьютера? Срочно вызывайте скорую, в таких случаях лучше не рисковать, а сразу доверить себя специалистам-врачам. Даже если вы будете рожать в карете скорой помощи (всякое случается), врачи примут ваши роды грамотно! А вот таксист или муж – маловероятно.</p>
                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                    </div>
                </div>

                <div class="block-in contractions-result contractions-result-7" style="display: none;">
                    <div class="box-left">
                        <div class="result-text">
                            <img src="/images/img_contractions_result_01.jpg"><br>
                            Собирайтесь в<br>роддом!
                        </div>
                    </div>
                    <div class="box-main">
                        <div class="summary-title">Рекомендации:</div>
                        <p>Скоро начнутся роды!</p>
                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                    </div>
                </div>

                <div class="block-in contractions-result contractions-result-8" style="display: none;">
                    <div class="box-left">
                        <div class="result-text">
                            <img src="/images/img_contractions_result_02.jpg" /><br/>
                            Обратитесь к<br/>врачу
                        </div>
                    </div>
                    <div class="box-main">
                        <div class="summary-title">Рекомендации:</div>
                        <p>Может быть, это ложные схватки, а может быть, начало патологических родов. Срочно обратитесь к врачу!</p>
                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                    </div>
                </div>

                <div class="block-in contractions-result contractions-result-9" style="display: none;">
                    <div class="box-left">
                        <div class="result-text">
                            <img src="/images/img_contractions_result_03.jpg" /><br/>
                            Будьте внимательны!
                        </div>
                    </div>
                    <div class="box-main">
                        <div class="summary-title">Рекомендации:</div>
                        <p>Скорее всего, вы ведете счет неправильно. Постарайтесь жать на кнопку точнее – именно в момент начала схваток и в момент их окончания.</p>
                        <br/>
                        <center><a class="to-contractions-data" href="#">Таблица Ваших схваток</a></center>
                    </div>
                </div>

        </div>
    </div>
</div>