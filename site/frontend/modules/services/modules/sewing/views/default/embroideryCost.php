<?php
/* @var $this Controller
 * @var $form CActiveForm
 */

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/embroideryCost.js', CClientScript::POS_HEAD);
$this->meta_description = 'Долгий процесс вышивания закончен – работа удалась на славу. Есть даже человек, который очень хочет купить ваше произведение искусства. Воспользуйтесь нашим сервисом, чтобы определить стоимость вышивки, и смело называйте цену';
$model = new EmbroideryCostForm();
?>
<div class="right_block">
    <div class="cost_calculation">
        <h1>Расчет стоимости <span>вышитой картины</span></h1>

        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'embroideryCost-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('embroideryCost'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    embroideryCost.calc(document.getElementById('embroideryCost-form'));
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
                <input type="checkbox" onclick="embroideryCost.activate(this, 'EmbroideryCostForm_colors_count')" name="EmbroideryCostForm[more_colors]" id="ch1" class="CheckBoxClass"/>
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
                <input type="checkbox" id="ch4" name="EmbroideryCostForm[small_canva]" onclick="embroideryCost.activate(this, 'EmbroideryCostForm_canva')" class="CheckBoxClass"/>
                <label for="ch4" class="CheckBoxLabelClass">
                    Мелкая канва, добавляем <span>5-20%</span>
                    <ins>Аида 14 считается нормальным размером</ins>
                </label>
            </p>
            <div class="input-box">
                <span class="units">Размер канвы в схеме:</span>

                <?php echo $form->dropDownList($model, 'canva', array('1' => '7','2' => '11','3' => '14','5' => '16',
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
                <input type="checkbox" id="ch7" onclick="embroideryCost.activate(this, 'EmbroideryCostForm_design_price')" name="EmbroideryCostForm[user_design]" class="CheckBoxClass"/>
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