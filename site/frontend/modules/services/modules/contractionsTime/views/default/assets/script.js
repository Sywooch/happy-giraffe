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

    service_used(7);

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