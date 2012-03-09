<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?>
<?php
$js = <<<EOD
    function StartCalc(stitchcount) {
        var w = parseInt(document.getElementById("EmbroideryCostForm_width").value);
        var h = parseInt(document.getElementById("EmbroideryCostForm_height").value);
        var crossprice = (document.getElementById("EmbroideryCostForm_cross_price").value).replace(',', '.');
        var pricematerals = parseInt(document.getElementById("EmbroideryCostForm_material_price").value);

        if (isNaN(w) || isNaN(h) || isNaN(crossprice) || isNaN(pricematerals) || crossprice === '' || pricematerals === ''){
            $('#result').html('');
            return false;
        }

        var ch1f = document.getElementById("EmbroideryCostForm_colors_count").value;
        var ch4f = document.getElementById("EmbroideryCostForm_canva").value;
        var ch7f = document.getElementById("EmbroideryCostForm_design_price").value;

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
        if (ch4f < 5) ch4f = 0;
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

    function activate(par, related_id) {
        if (par.checked) {
            document.getElementById(related_id).disabled = false;
            $('#'+related_id).trigger("liszt:updated");
        }
        else {
            document.getElementById(related_id).disabled = true;
            $('#'+related_id).trigger("liszt:updated");
        }
    }
EOD;

Yii::app()->clientScript->registerScript('embroideryCost', $js, CClientScript::POS_HEAD);
$model = new EmbroideryCostForm();
?>
<div class="right_block">
    <div class="cost_calculation">
        <h1>Расчет стоимости <span>вышитой картины</span></h1>

        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'embroideryCost-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('/sewing/default/EmbroideryCost'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc(document.getElementById('embroideryCost-form'));
                                else
                                    $('#result').html('');
                                return false;
                              }",
        )));?>
        <p class="form_header">Базовая стоимость</p>

        <div class="form_block first clearfix">
            <p>Введите размер картины в "крестиках":</p>

            <div>
                <label>Ширина</label>
                <?php echo $form->textField($model, 'width') ?>
                <?php echo $form->error($model, 'width'); ?>
            </div>
            <div>
                <label>Высота</label>
                <?php echo $form->textField($model, 'height') ?>
                <?php echo $form->error($model, 'height'); ?>
            </div>
        </div>
        <div class="form_block">
            <p>Цена одного "крестика"<span>обычно это 0,01-0,5 руб</span></p>
            <?php echo $form->textField($model, 'cross_price') ?><label>руб</label>
            <?php echo $form->error($model, 'cross_price'); ?>
        </div>
        <div class="form_block">
            <p>Стоимость материалов:<span>канва, нитки, рамка и т.д.</span></p>
            <?php echo $form->textField($model, 'material_price') ?><label>руб</label>
            <?php echo $form->error($model, 'material_price'); ?>
        </div>
        <div class="clear"></div>
        <p class="form_header" id="form-header">
            <ins>+</ins>
            Дополнительная стоимость
            <span>(усложняющие элементы)</span>
        </p>
        <div class="form_big_block">
            <p class="children">Отметьте условия работы, которые будут входить в стоимость</p>

            <div>
            <p>
                <input type="checkbox" onclick="activate(this, 'EmbroideryCostForm_colors_count')" name="ch1" id="ch1" class="CheckBoxClass"/>
                <label for="ch1" class="CheckBoxLabelClass">
                    Если в схеме более 25 цветов, добавляем <span>1%</span> за каждый цвет
                </label>
            </p>
            </div>

            <div>
            <p class="children">

                <label>Количество цветов в схеме:</label>
                <?php echo $form->textField($model, 'colors_count', array('disabled' => 'disabled')) ?>
                <?php echo $form->error($model, 'colors_count'); ?>
            </p>
            </div>

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
                <input type="checkbox" id="ch4" name="ch4" onclick="activate(this, 'EmbroideryCostForm_canva')" class="CheckBoxClass"/>
                <label for="ch4" class="CheckBoxLabelClass">
                    Мелкая канва, добавляем <span>5-20%</span>
                    <ins>Аида 14 считается нормальным размером</ins>
                </label>
            </p>
            <div class="input-box">
                <span class="units">Размер канвы в схеме:</span>

                <?php echo $form->dropDownList($model, 'canva', array('0' => '7','1' => '11','2' => '14','5' => '16',
                '10' => '18','15' => '20','20' => '22','25' => '25'), array('class'=>'chzn','empty'=>'-', 'disabled'=>'disabled')) ?>
                <?php echo $form->error($model, 'canva'); ?>

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
                <input type="checkbox" id="ch7" onclick="activate(this, 'EmbroideryCostForm_design_price')" name="ch7" class="CheckBoxClass"/>
                <label for="ch7" class="CheckBoxLabelClass">
                    Сами разрабатывали схему? Добавьте стоимость её разработки
                </label>
            </p>

            <div>
            <p class="children">
                <label>Стоимость вашего дизайна:</label>
                <?php echo $form->textField($model, 'design_price', array('disabled' => 'disabled')) ?>
                <?php echo $form->error($model, 'design_price'); ?>
            </p>
            </div>
        </div>

        <input type="submit" value="Рассчитать"/>

        <?php echo $form->errorSummary($model) ?>
        <div id="result">
        </div>
        <?php $this->endWidget(); ?>
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
            <li>Если вы являетесь автором использованной схемы вышивки – прибавьте стоимость её разработки в рублях.
            </li>
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