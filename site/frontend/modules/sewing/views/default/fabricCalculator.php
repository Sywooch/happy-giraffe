<style type="text/css">
    input {
        border: 1px solid #000;
    }
</style>
<script language="javascript" type="text/javascript">
    function pushed() {
        var LEN = document.getElementById("len").value;
        var NIT = document.getElementById("nit").value;
        var PLUS = document.getElementById("plus").value;
        var W = document.getElementById("w").value;
        var H = document.getElementById("h").value;
        if (!parseInt(PLUS) && parseInt(PLUS) != 0 || !parseInt(W) || !parseInt(H) || !parseInt(NIT)) {
            alert('Введите целое число.');
            return;
        }
        LEN = parseInt(LEN);
        NIT = parseInt(NIT);
        PLUS = parseInt(PLUS);
        W = parseInt(W);
        H = parseInt(H);
        var RES_W = W * NIT / LEN * 2.54 + PLUS * 2;
        var RES_H = H * NIT / LEN * 2.54 + PLUS * 2;
        RES_W = Math.round(RES_W);
        RES_H = Math.round(RES_H);
        document.getElementById("res").innerHTML = 'ширина = ' + RES_W + ' см, высота = ' + RES_H + ' см';
    }

    function clean() {
        document.getElementById("res").innerHTML = '';
        document.getElementById("w").value = "";
        document.getElementById("h").value = "";
        document.getElementById("plus").value = "";
        document.getElementById("nit").value = "";
    }
    function pushed1() {
        var AIDA = document.getElementById("aida").value;
        var PLUS1 = document.getElementById("plus1").value;
        var W1 = document.getElementById("w1").value;
        var H1 = document.getElementById("h1").value;
        if (!parseInt(PLUS1) && parseInt(PLUS1) != 0 || !parseInt(W1) || !parseInt(H1)) {
            alert('Введите целое число.');
            return;
        }
        AIDA = parseInt(AIDA);
        PLUS = parseInt(PLUS1);
        W1 = parseInt(W1);
        H1 = parseInt(H1);
        var RES_W = W1 / AIDA * 2.54 + PLUS1 * 2;
        var RES_H = H1 / AIDA * 2.54 + PLUS1 * 2;
        RES_W = Math.round(RES_W);
        RES_H = Math.round(RES_H);
        document.getElementById("res1").innerHTML = 'ширина = ' + RES_W + ' см, высота = ' + RES_H + ' см';

    }
    function clean1() {
        document.getElementById("res1").innerHTML = '';
        document.getElementById("w1").value = "";
        document.getElementById("h1").value = "";
        document.getElementById("plus1").value = "";

    }
</script>

<h3 align="center"><font face="Verdana" size="2">КАЛЬКУЛЯТОР ТКАНИ</font></h3>

<div style="padding-left: 7px; padding-right: 7px" class="text"><font face="Verdana" size="2">Если вы хотите узнать
    размер готовой вышивки, то в графе для
    припусков поставьте "0". Результат выводится с округлением до целого числа в
    сантиметрах.</font></div>
<hr size="1" color="#84DAFF">

<div class="text">
    <h4 align="center"><font face="Verdana" size="2">Для льна или другой ткани равномерного переплетения</font></h4>
    <font face="Verdana"><font size="2">Введите размер схемы в стежках:<br>
        по ширине </font> <input type="text" size="5" id="w"><font size="2">
        по высоте </font> <input type="text" size="5" id="h"><font size="2"><br>

        Введите количество нитей для одного "креста":
    </font>
        <input type="text" value="2" size="3" id="nit"><font size="2"><br>
            (обычно это 2х2 нити)<br>
            Прибавьте на припуски с каждой стороны:
        </font>
        <input type="text" value="5" size="3" id="plus"><font size="2"> см<br>

            Выберите номер ткани:
        </font>
        <select id="len">

            <option value="22">25</option>
            <option value="27">27</option>
            <option value="28" selected="">28</option>
            <option value="32">32</option>
            <option value="36">36</option>

        </select><font size="2"><br>

            (количество нитей в 1 дюйме)
        </font></font>

    <p>


        <strong><font size="4" color="red" id="res"></font></strong>

    </p>
    <hr size="1" color="#84DAFF">

    <center>
        <font face="Verdana">
            <input type="button" value="Очистить" onclick="clean()"><font size="2"> </font>

            <input type="button" value="Рассчитать" onclick="pushed()"><font size="2">
        </font></font>
    </center>
</div>


<div class="text">
    <h4 align="center"><font face="Verdana" size="2">Для канвы</font></h4>

    <font face="Verdana"><font size="2">Введите размер схемы в крестиках:<br>
        по ширине </font> <input type="text" size="5" id="w1"><font size="2">

        по высоте </font> <input type="text" size="5" id="h1"><font size="2"><br>

        Прибавьте на припуски (будет прибавлено с каждой стороны):
    </font>
        <input type="text" value="5" size="3" id="plus1"><font size="2"> см<br>

            Выберите номер канвы:
        </font>
        <select id="aida">
            <option value="11">11</option>
            <option value="14" selected="">14</option>

            <option value="16">16</option>
            <option value="18">18</option>
            <option value="22">22</option>
        </select><font size="2"><br>
            (количество клеток в 1 дюйме)
        </font></font>

    <p>


        <strong><font size="4" color="red" id="res1"></font></strong>

    </p>
    <hr size="1" color="#84DAFF">

    <center>
        <font face="Verdana">
            <input type="button" value="Очистить" onclick="clean1()"><font size="2"> </font>
            <input type="button" value="Рассчитать" onclick="pushed1()"><font size="2">
        </font>

            <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
        </font></center>
    <font face="Verdana">
    </font></div>
