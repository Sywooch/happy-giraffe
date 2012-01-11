<?php
$js = <<<EOD
    function calculate(stitchcount) {
        var w = parseInt(document.getElementById("w").value);
        var h = parseInt(document.getElementById("h").value);
        var crossprice = (document.getElementById("crossprice").value).replace(',', '.');
        var pricematerals = parseInt(document.getElementById("pricematerals").value);

        if (isNaN(w) || isNaN(h) || isNaN(crossprice) || isNaN(pricematerals) || crossprice === '' || pricematerals === ''){
            $('#result').html('');
            return false;
        }

        var ch1f = document.getElementById("ch1f").value;
        var ch4f = document.getElementById("ch4f").value;
        var ch7f = document.getElementById("ch7f").value;

        if (isNaN(ch1f) || ch1f === "") ch1f = 0;
        if (isNaN(ch4f) || ch4f === "") ch4f = 0;
        if (isNaN(ch7f) || ch7f === "") ch7f = 0;

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

        $('#result').html('<div class="total_block">' +
            '<p>Базовая стоимость работы:<span>' + baseprice +
            '</span></p>' +
            '<p>Стоимость усложняющих элементов:<span>' + complexelemprice +
            '</span>' +
            '</p><p class="big">ИТОГО:<span>' + totalprice +
            ' руб</span></p></div>');
        $('html,body').animate({scrollTop: $('#form-header').offset().top},'fast');
        return false;
    }

    function activate(par) {
        if (par.checked) {
            document.getElementById(par.name + 'f').disabled = false;
            $('#cuselFrame-' + par.name + 'f').removeClass("classDisCusel");
        }
        else {
            document.getElementById(par.name + 'f').disabled = true;
            $('#cuselFrame-' + par.name + 'f').addClass("classDisCusel");
        }
    }
EOD;

Yii::app()->clientScript->registerScript('embroideryCost', $js, CClientScript::POS_HEAD);
?>
<div class="right_block">
    <div class="cost_calculation">
        <h1>Расчет стоимости <span>вышитой картины</span></h1>

        <form action="#">
            <p class="form_header">Базовая стоимость</p>

            <div class="form_block first">
                <p>Введите размер картины в "крестиках":</p>
                <label>Ширина</label><input type="text" id="w" value=""/>
                <label>Высота</label><input type="text" id="h" value=""/>
            </div>
            <div class="form_block">
                <p>Цена одного "крестика"<span>обычно это 0,01-0,5 руб</span></p>
                <input type="text" id="crossprice" value="0,01"/><label>руб</label>
            </div>
            <div class="form_block">
                <p>Стоимость материалов:<span>канва, нитки, рамка и т.д.</span></p>
                <input type="text" id="pricematerals" value=""/><label>руб</label>
            </div>
            <div class="clear"></div>
            <p class="form_header" id="form-header">
                <ins>+</ins>
                Дополнительная стоимость
                <span>(усложняющие элементы)</span>
            </p>
            <div class="form_big_block">
                <p class="children">Отметьте условия работы, которые будут входить в стоимость</p>

                <p>
                    <input type="checkbox" onclick="activate(this)" name="ch1" id="ch1" class="CheckBoxClass"/>
                    <label for="ch1" class="CheckBoxLabelClass">
                        Если в схеме более 25 цветов, добавляем <span>1%</span> за каждый цвет
                    </label>
                </p>

                <p class="children">
                    <label>Количество цветов в схеме:</label>
                    <input type="text" value="25" id="ch1f" disabled="disabled"/>
                </p>

                <p>
                    <input type="checkbox" id="ch2" name="ch2" class="CheckBoxClass"/>
                    <label for="ch2" class="CheckBoxLabelClass">
                        Большое количество одиночных “крестиков” значительно усложняет процесс вышивки,
                        добавляем <span>20%</span>
                    </label>
                </p>

                <p>
                    <input type="checkbox" id="ch3" name="ch3" class="CheckBoxClass"/>
                    <label for="ch3" class="CheckBoxLabelClass">
                        Темная канва, вышивка по которой значительно сложнее, добавляем <span>25%</span>
                    </label>
                </p>

                <p>
                    <input type="checkbox" id="ch4" name="ch4" onclick="activate(this)" class="CheckBoxClass"/>
                    <label for="ch4" class="CheckBoxLabelClass">
                        Мелкая канва, добавляем <span>5-20%</span>
                        <ins>Аида 14 считается нормальным размером</ins>
                    </label>
                </p>
                <div class="input-box">
                    <span class="units">Размер канвы в схеме:</span>

                    <select id="ch4f" disabled="disabled" name="ch4f">
                        <option value="0">7</option>
                        <option value="0">11</option>
                        <option selected="" value="0">14</option>
                        <option value="5">16</option>
                        <option value="10">18</option>
                        <option value="15">20</option>
                        <option value="20">22</option>
                        <option value="25">25</option>
                    </select>

                    <div class="clear"></div>
                </div>
                <p>
                    <input type="checkbox" id="ch5" name="ch5" class="CheckBoxClass"/>
                    <label for="ch5" class="CheckBoxLabelClass">
                        Срочный заказ, добавляем <span>25%</span>
                    </label>
                </p>

                <p>
                    <input type="checkbox" id="ch6" name="ch6" class="CheckBoxClass"/>
                    <label for="ch6" class="CheckBoxLabelClass">
                        Наличие дополнительных элементов, добавляем <span>25%</span>
                        <ins>(бекстич, французские узелки, коучинг, бисер, ленты)</ins>
                    </label>
                </p>
                <p>
                    <input type="checkbox" id="ch7" onclick="activate(this)" name="ch7" class="CheckBoxClass"/>
                    <label for="ch7" class="CheckBoxLabelClass">
                        Сами разрабатывали схему? Добавьте стоимость её разработки!
                    </label>
                </p>

                <p class="children">
                    <label>Итак, ваш дизайн стоит:</label>
                    <input type="text" id="ch7f" value="0" disabled="disabled" name="ch7f"/>
                </p>
            </div>

            <input type="submit" value="Рассчитать" onclick="return calculate(this.form)"/>
        </form>
        <div id="result">
        </div>
    </div>
</div>
<div class="seo-text">
    <h1 class="summary-title">Расчёт стоимости вышивки</h1>

    <p>Вы вышивали долго и упорно картину. А теперь она так понравилась знакомой, что та готова купить её за любые
        деньги! Она-то готова, а вы сомневаетесь: и продешевить не хочется, и слишком высокую цену назначать
        неудобно.</p>

    <div class="brushed">
        <p>Воспользуйтесь независимым оценщиком – нашим сервисом по расчёту стоимости готовой вышивки. Для этого нужно
            будет учесть все детали (но вы же их помните, правда?):</p>
        <ul>
            <li>количество крестиков в ряду (ширина работы),</li>
            <li>количество крестиков в высоту (высота работы),</li>
            <li>стоимость одного крестика,</li>
            <li>стоимость материалов (включите сюда схему, канву или ткань, нитки, услуги багетной мастерской).</li>
        </ul>
        <p>Если картина сложная, то обязательно добавьте:</p>
        <ul>
            <li>1% за каждый цвет сверх 25,</li>
            <li>20% за большое количество одиночно расположенных крестиков,</li>
            <li>25% за вышивку по тёмной или цветной канве,</li>
            <li>от 5 до 20% за вышивку на мелкой канве (менее 14 размера),</li>
            <li>25% за срочность выполнения работы,</li>
            <li>15% за украшение вышивки узелками, бисером, лентами и другими декоративными элементами,</li>
            <li>Если вы являетесь автором использованной схемы вышивки – прибавьте стоимость её разработки в рублях.</li>
        </ul>
        <p>После того как всё учтено – смело нажимайте на кнопку «рассчитать», и вы получите:</p>
        <ul>
            <li>стоимость основной работы,</li>
            <li>стоимость декоративных элементов,</li>
            <li>итоговую стоимость работы.</li>
        </ul>
    </div>
    <p>Теперь вы точно знаете, сколько стоит ваш труд!</p>
</div>