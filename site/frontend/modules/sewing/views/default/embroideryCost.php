<style type="text/css">
    input{
        border: 1px solid #000;
    }
</style>
<script type="text/javascript">
    function calculate(stitchcount) {
        var w = parseInt(document.getElementById("w").value);
        var h = parseInt(document.getElementById("h").value);
        var crossprice = (document.getElementById("crossprice").value).replace(',', '.');
        var pricematerals = parseInt(document.getElementById("pricematerals").value);

        var ch1f = document.getElementById("ch1f").value;
        var ch4f = document.getElementById("ch4f").value;
        var ch7f = document.getElementById("ch7f").value;
        if (ch1f < 25) {
            ch1f = 0
        } else {
            ch1f = ch1f - 25
        }
        if (stitchcount.ch2.checked) {
            var ch2f = 20
        } else {
            ch2f = 0
        }
        if (stitchcount.ch3.checked) {
            var ch3f = 25
        } else {
            ch3f = 0
        }
        if (stitchcount.ch5.checked) {
            var ch5f = 25
        } else {
            ch5f = 0
        }
        if (stitchcount.ch6.checked) {
            var ch6f = 15
        } else {
            ch6f = 0
        }

        ch1f = parseInt(ch1f);
        ch2f = parseInt(ch2f);
        ch3f = parseInt(ch3f);
        ch4f = parseInt(ch4f);
        ch5f = parseInt(ch5f);
        ch6f = parseInt(ch6f);
        ch7f = parseInt(ch7f);

        var s = w * h;
        var allcrossprice = s * crossprice;

        if (s >= 40000) {
            var ch8f = allcrossprice * 0.15
        } else {
            ch8f = 0
        }
        var baseprice = allcrossprice + pricematerals;
        complexelemprice = (ch1f + ch2f + ch3f + ch4f + ch5f + ch6f) * allcrossprice / 100 + ch7f + ch8f;
        totalprice = baseprice + complexelemprice;
        baseprice = Math.round(baseprice);
        totalprice = Math.round(totalprice);
        complexelemprice = Math.round(complexelemprice);

        document.getElementById("baseprice").innerHTML = 'Базовая стоимость работы ' + baseprice;
        document.getElementById("complexelemprice").innerHTML = 'Стоимость усложняющих элементов ' + complexelemprice;
        document.getElementById("totalprice").innerHTML = 'Итоговая стоимость: ' + totalprice;
    }

    function activate(par) {
        if (par.checked) {
            document.getElementById(par.name + 'f').disabled = false
            $('#cuselFrame-'+par.name + 'f').removeClass("classDisCusel");
        }
        else {
            document.getElementById(par.name + 'f').disabled = true;
            document.getElementById(par.name + 'f').value = '0'
            $('#cuselFrame-'+par.name + 'f').addClass("classDisCusel");
        }
    }
</script>

<form name="stitchcount">
    <table>
        <tbody>
        <tr>
            <td>Ширина картины, крестиков</td>
            <td><input type="text" size="5" value="100" id="w"></td>
        </tr>
        <tr>
            <td>Высота картины, крестиков</td>
            <td><input type="text" size="5" value="100" id="h"></td>
        </tr>
        <tr>
            <td>Цена одного крестика</td>
            <td><input type="text" size="10" value="0,05" id="crossprice"></td>
        </tr>
        <tr>
            <td>Стоимость материалов (канва, нитки, рамка...)</td>
            <td><input type="text" size="10" value="150" id="pricematerals"></td>
        </tr>
        </tbody>
    </table>
    <p>Эти числа дают нам базовую стоимость работы. Однако стоимость может зависеть ещё от множества других параметров.
        Итак смотрим и отмечаем нужные:</p>
    <ul>
        <li><input type="checkbox" onclick="activate(this)" id="ch1" name="ch1"> за каждый цвет, если общее количество
            цветов в схеме болше 25, добавляем 1%<br>Количество используемых в схеме цветов:
            <input type="text" size="10" value="25" id="ch1f" disabled="disabled" name="ch1f"></li>
        <li><input type="checkbox" id="ch2" name="ch2"> большое количество одиночных крестиков значительно усложняет
            процесс вышивки, добавляем +20%
        </li>
        <li><input type="checkbox" id="ch3" name="ch3">
            тёмная канва, вышивка по которой значительно сложнее, добавляем + 25%
        </li>
        <li><input type="checkbox" onclick="activate(this)" id="ch4" name="ch4"> мелкая канва (Аида 14 считается
            нормальным размером), добавляем 5-20%<br>Размер используемой в схеме канвы:
            <select id="ch4f" disabled="disabled" name="ch4f">
                <option value="0">7</option>
                <option value="0">11</option>
                <option selected="" value="0">14</option>
                <option value="5">16</option>
                <option value="10">18</option>
                <option value="15">20</option>
                <option value="20">22</option>
                <option value="25">25</option>
            </select></li>
        <li><input type="checkbox" id="ch5" name="ch5"> срочный заказ, добавляем 25%</li>
        <li><input type="checkbox" id="ch6" name="ch6"> наличие дополнительных элементов (бекстич, французские узелки,
            коучинг, бисер, ленты), добавляем 15%
        </li>
        <li><input type="checkbox" onclick="activate(this)" id="ch7" name="ch7">&nbsp;сами разрабатывали схему? Добавьте
            стоимость её разработки! Итак, ваш дизайн стоит: <br>
            <input type="text" size="15" value="0" id="ch7f" disabled="disabled" name="ch7f"></li>
    </ul>
    <p><strong><font size="2" color="#6b8e23" id="baseprice"></font></strong><br>
        <strong><font size="2" color="#6b8e23" id="complexelemprice"></font></strong></p>
    <hr>
    <strong><font size="4" color="#ff6347" id="totalprice"></font></strong><br>

    <p></p>
    <center><input type="button" value="Рассчитать!" onclick="calculate(this.form)"></center>
</form>