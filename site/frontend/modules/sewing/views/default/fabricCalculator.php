<script language="javascript" type="text/javascript">
    function pushed() {
        var LEN = document.getElementById("len").value;
        var NIT = document.getElementById("nit").value;
        var PLUS = document.getElementById("plus").value;
        var W = document.getElementById("w").value;
        var H = document.getElementById("h").value;
        if (!parseInt(PLUS) && parseInt(PLUS) != 0 || !parseInt(W) || !parseInt(H) || !parseInt(NIT)) {
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
        document.getElementById("res").innerHTML = RES_W + ' x ' + RES_H + ' см';
        $('#res').show();
    }

    function pushed1() {
        var AIDA = document.getElementById("aida").value;
        var PLUS1 = document.getElementById("plus1").value;
        var W1 = document.getElementById("w1").value;
        var H1 = document.getElementById("h1").value;
        if (!parseInt(PLUS1) && parseInt(PLUS1) != 0 || !parseInt(W1) || !parseInt(H1)) {
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
        document.getElementById("res1").innerHTML = RES_W + ' x ' + RES_H + ' см';
        $('#res1').show();

    }
</script>
<div class="embroidery_service">
    <img src="/images/service_much_tissue.jpg" alt="" title=""/>

    <div class="tissue_left">
        <div class="tissue_type">
            <span><ins>Для льна</ins>или другой ткани<br/>равномерного переплетения</span>

            <div class="style_rarr"></div>
            <!-- .style_rarr -->
        </div>
        <!-- .tissue_type -->
        <div class="tissue_calc">
            <ul>
                <li>
                    <ins>Введите размер схемы<br/> в стежках:</ins>
                    Ширина <input type="text" class="wh_t" id="w"/>
                    Высота <input type="text" class="wh_t" id="h"/>
                </li>
                <li>
                    <ins>Введите количество нитей для <br/>одного “креста:<input type="text" class="much_t" id="nit"/>
                    </ins>
                    (обычно это 2х2 нити)
                </li>
                <li>
                    <ins>Прибавьте на припуски: <input type="text" class="much_t" id="plus"/> см</ins>
                    (будет прибавлено с каждой стороны)
                </li>
                <li>
                    <ins>Выберите номер ткани:
                        <?php echo CHtml::dropDownList('size', 28, array(25 => 25, 27 => 27, 28 => 28, 32 => 32, 36 => 36), array('id' => 'len', 'class' => "num_cal")) ?>
                    </ins>
                    (количество нитей в одном дюйме)
                </li>
            </ul>
            <input type="button" class="calc_bt" value="Рассчитать" onclick="pushed()"/>
        </div>
        <!-- .tissue_calc -->
        <div class="tissue_result" id="res" style="display: none;">
            64 x 64 <span>см</span>
        </div>
        <!-- .tissue_result -->
    </div>
    <!-- .tissue_left -->
    <div class="tissue_right">
        <div class="tissue_type">
            <span><ins>Для канвы</ins></span>

            <div class="style_rarr"></div>
            <!-- .style_rarr -->
        </div>
        <!-- .tissue_type -->
        <div class="tissue_calc">
            <ul>
                <li>
                    <ins>Введите размер схемы<br/> в стежках:</ins>
                    Ширина <input type="text" class="wh_t" id="w1"/>
                    Высота <input type="text" class="wh_t" id="h1"/>
                </li>
                <li>
                    <ins>Введите количество нитей для <br/>одного “креста:<input type="text" class="much_t" id="plus1"/>
                    </ins>
                    (обычно это 2х2 нити)
                </li>
                <li>
                    <ins>Выберите номер ткани:
                        <?php echo CHtml::dropDownList('size', 14, array(11 => 11, 14 => 14, 16 => 16, 18 => 18, 22 => 22), array('id' => 'aida', 'class' => "num_cal")) ?>
                    </ins>
                    (количество нитей в одном дюйме)
                </li>
            </ul>
            <input type="button" class="calc_bt" value="Рассчитать" onclick="pushed1()"/>
        </div>
        <!-- .tissue_calc -->
        <div class="tissue_result" id="res1" style="display: none;">
            64 x 64 <span>см</span>
        </div>
        <!-- .tissue_result -->
    </div>
    <!-- .tissue_right -->
</div><!-- .embroidery_service -->	