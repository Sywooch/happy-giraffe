<?php
$js = <<<EOD
    //Timer
    var mins,secs,TimerRunning,TimerID;
    TimerRunning=false;

     function InitTimer() //call the Init function when u need to start the timer
     {
        mins=0;
        secs=0;
        StopTimer();
        StartTimer();
     }

     function StopTimer()
     {
        if(TimerRunning)
           clearTimeout(TimerID);
        TimerRunning=false;
     }

     function StartTimer()
     {
        TimerRunning=true;
        TimerID=self.setTimeout(StartTimer,1000);
         $('#timer').html(Pad(mins)+":"+Pad(secs));

        secs++;
        if(secs==60)
        {
           mins++;
           secs=0;
        }
     }

     function Pad(number)
     {
        if(number<10)
           number=0+""+number;
        return number;
     }

    //Contractions
    var status=0;
    var counter=0;
    var stopped = false;
    var list=new Array();
    var current = null;
    var phase = 0;

    Shvatka = function ()
    {
    	this.begin = 0;
    	this.end = 0;
    	this.length = 0;
    	this.before = null;
    }

    Shvatka.prototype.setDataToTable = function()
    {
    	counter++;
    	var pr = this.before == null ? "-" : getTimeString(this.before);
        var trClass = '';
        if (list.length % 2 == 0)
            trClass = ' class="even"';
        $(".result-table a.remove").hide();

    	$(".result-table").append("<tr id='data"+counter+"'"+trClass+"><td></td><td class='col-1'>"+counter
            +"</td><td class='col-2'>"+getTime(this.begin)
            +"</td><td class='col-3'>"+getTime(this.end)
            +"</td><td class='col-4'>"+getTimeString(this.length)
            +"</td><td class='col-5'>"+pr
            +"</td><td class='col-6'><a class='remove' href='#'>Удалить</a></td>"
            +"</tr>");
    }

    getTimeString = function (time)
    {
    	var hours = (time - (time%3600000))/3600000;
    	time-=hours * 3600000;
    	var mins = (time - (time%60000))/60000;
    	time-=mins * 60000;
    	var secs = Math.round(time/1000).toString();
        time-=secs * 1000;
        var milisecs = time.toString();
        if (milisecs > 500)
            secs++;
        if (secs == 60){
            secs = 0;
            mins++;
        }
        if (mins == 60){
            mins = 0;
            hours++;
        }
        return ((mins.length > 1 ? mins : "0" + mins)+":"+(secs.length > 1 ? secs : "0" + secs))
    }

    function getTime(data)
    {
    	var time=new Date();
    	time.setTime(data);
        var hours=time.getHours();
    	var mins=time.getMinutes();
    	var secs=time.getSeconds();
        var milisecs=time.getMilliseconds();

        if (milisecs > 500)
            secs = secs+1;
        if (secs == 60){
            secs = 0;
            mins++;
        }
        if (mins == 60){
            mins = 0;
            hours++;
        }
        if (hours == 24)
            hours = 0;

        hours=hours.toString();
    	mins=mins.toString();
    	secs=secs.toString();
        milisecs=milisecs.toString();

    	return ((hours.length > 1 ? hours : "0" + hours)+":"+(mins.length > 1 ? mins : "0" + mins)
                    +":"+(secs.length > 1 ? secs : "0" + secs))
    }

    function startSH()
    {
    	current = new Shvatka();
    	var date = new Date();
    	current.begin=date.getTime();
        InitTimer();

        //change button
        $('#start-count').parent().addClass('started');
        $('#start-count').text('Финиш');
    }

    function stopSH()
    {
    	var date = new Date();
    	current.end=date.getTime();
    	current.length=current.end - current.begin;
    	if(list.length>0) current.before=current.begin-list[list.length-1].end;
    	list.push(current);
    	current.setDataToTable();
    	current=null;
        StopTimer();

        //change button
        $('#start-count').parent().removeClass('started');
        $('#start-count').text('Старт!');
    }

    function press()
    {
        if (stopped){
            stopped = false;
            status=0;
            counter=0;
            stopped = false;
            list=new Array();
            current = null;
            phase = 0;
            $('.contractions-result').hide();
            $('.contractions-data').show();
            $(".result-table tbody").empty();
            $('.to-contractions-info').hide();
            $('#start-count').text('Старт!');
            $('#contractions-remain big').html('Еще 5 схваток');
            return;
        }

    	if (status == 0)
    	{
    		status=1;
    		startSH();
    	}
    	else
    	{
    		status=0;
    		stopSH();
    	}
        RemainsCount();
        if (list.length >=5)
            StopCounting();
    }

    function RemainsCount(){
        var remains = (5 - list.length);
        if (remains == 1)
            $('#contractions-remain big').html('Еще 1 схватка');
        else {
            if (remains == 0 || remains == 5)
                $('#contractions-remain big').html('Еще '+remains+' схваток');
            else
                $('#contractions-remain big').html('Еще '+(5 - list.length)+' схватки');
        }
    }

    function deleteLast()
    {
    	$("#data" + counter).remove();
    	counter--;
    	list.pop();
    }



    $(function() {
        $('#start-count').click(function(){
            press();
            return false;
        });

        $('.result-table').delegate('.remove','click',function(){
            if (stopped)
                return false;

//            index = $('#result-table a.remove').index($(this));
            //find row number
//            list.splice(index, 1);
//            $(this).parent().parent().remove();
            deleteLast();
            $(".result-table a.remove:last").show();
            RemainsCount();

            return false;
        });

        $('.to-contractions-data').click(function(){
            $('.contractions-result').hide();
            $('.to-contractions-info').show();
            $('.contractions-data').show();
            return false;
        });

        $('.to-contractions-info').click(function(){
            $('.contractions-data').hide();
            $('.to-contractions-info').hide();
            $('.contractions-result-'+phase).show();
            return false;
        });

        $(document).keydown(function(e) {
            if(e.keyCode == 13) {
                press();
                return false;
            }
            if(e.keyCode == 32) {
                press();
                return false;
            }
        });
    });

    //For testing service
    function Test(){
        list=new Array();
        current = new Shvatka();
        current.before = null;
        current.length = 15000;
        list.push(current);

        current = new Shvatka();
        current.before = 450000;
        current.length = 14000;
        list.push(current);

        current = new Shvatka();
        current.before = 450000;
        current.length = 14000;
        list.push(current);

        current = new Shvatka();
        current.before = 450000;
        current.length = 18000;
        list.push(current);

        current = new Shvatka();
        current.before = 450000;
        current.length = 11000;
        list.push(current);

        StopCounting();
    }

    //end counting and calculate result
    function StopCounting(){
        stopped = true;
        $('#start-count').text('Заново');

        var common_length = 0;
        var common_interval = 0;
        var phase = 0;

        for (var key in list) {
            var val = list[key];
            val.length = Math.abs(val.length / 1000);
            if (val.before !== null)
                val.before = Math.abs(val.before / 1000);
            common_length += val.length;
            common_interval += val.before;
        }

        var average_length = common_length / 5;
        var average_interval = common_interval / 4;
//        console.log(average_length, average_interval);

        var previous_val = null;
        var max_range = 10;
        var len_point_rise = average_length/500;
        var interval_point_rise = average_interval/500;
//        console.log(len_point_rise, interval_point_rise);

        for (var key in list) {
            var val = list[key];
            if (Math.abs(val.length - average_length) > (max_range + len_point_rise*2)){
//                console.log(11);
//                console.log(val.length - average_length);
                return ShowPhase(9);
            }
            if (val.before !== null)
                if (Math.abs(val.before - average_interval) > (max_range*2 + interval_point_rise*2)){
//                    console.log(22);
//                    console.log(val.before, average_interval);
                    return ShowPhase(9);
                }
        }

        var iter = 0;
        for (var key in list) {
            var val = list[key];
            if (previous_val !== null){
            if ((val.length - previous_val) > (max_range + len_point_rise*iter)
                || (val.length - previous_val) < (-max_range + len_point_rise*iter))
                return ShowPhase(9);
            }
            iter++;
            previous_val = list[key];
        }

        if (average_length < 30 && average_interval > 300)
            return ShowPhase(1);
        if (average_length < 30 && average_interval <= 300)
            return ShowPhase(2);
        if (average_length >= 30 && average_length < 45
            && average_interval >= 240 && average_interval < 600 )
            return ShowPhase(3);
        if (average_length >= 45 && average_length < 65
            && average_interval >= 60 && average_interval < 240 )
            return ShowPhase(4);
        if (average_length >= 65 && average_length < 90
            && average_interval >= 30 && average_interval < 60 )
            return ShowPhase(5);
        if (average_length >= 90 && average_interval < 30 )
            return ShowPhase(6);
        if (average_length >= 90
            && average_interval >= 60 && average_interval < 240 )
            return ShowPhase(7);

        return ShowPhase(8);
    }

    function ShowPhase(num){
        phase = num;
        $('.contractions-data').hide();
        $('.contractions-result-'+num).show();
    }
EOD;
Yii::app()->clientScript->registerScript('contractionsTime',$js);

?>
<div class="section-banner" style="margin:0;">
    <img src="/images/section_banner_06.jpg" />

    <div class="contractions-form">
        <button id="start-count">Старт!</button>
        <div class="time" id="timer">00:00</div>
    </div>
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
            <col width="20" />
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

    <div class="block-in contractions-data seo-text">

        <div class="summary-title">Считаем схватки</div>
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