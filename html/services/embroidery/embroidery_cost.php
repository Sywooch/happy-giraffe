<!DOCTYPE html>
<!--[if lt IE 8]>      <html class=" ie7"> <![endif]-->
<!--[if IE 8]>         <html class=" ie8"> <![endif]-->
<!--[if IE 9]>         <html class=" ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>

</head>
<body class="body-club">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/layout-header.php'; ?>
			
		<div id="content" class="layout-content clearfix">

		<div class="left-inner">

			<a href="/"><img src="/images/leftban.png"></a>
	
		</div>
	
<div class="right-inner">
        <div class="right_block">
    <div class="cost_calculation">
        <h1>Расчет стоимости <span>вышитой картины</span></h1>

        <form method="post" action="/sewing/embroideryCost/" id="embroideryCost-form">        <p class="form_header">Базовая стоимость</p>

        <div class="form_block first clearfix">
            <p>Введите размер картины в "крестиках":</p>

            <div>
                <label>Ширина</label>
                <input type="text" id="EmbroideryCostForm_width" name="EmbroideryCostForm[width]">                <div style="display:none" id="EmbroideryCostForm_width_em_" class="errorMessage"></div>            </div>
            <div>
                <label>Высота</label>
                <input type="text" id="EmbroideryCostForm_height" name="EmbroideryCostForm[height]">                <div style="display:none" id="EmbroideryCostForm_height_em_" class="errorMessage"></div>            </div>
        </div>
        <div class="form_block">
            <p>Цена одного "крестика"<span>обычно это 0,01-0,5 руб</span></p>
            <input type="text" id="EmbroideryCostForm_cross_price" name="EmbroideryCostForm[cross_price]"><label>руб</label>
            <div style="display:none" id="EmbroideryCostForm_cross_price_em_" class="errorMessage"></div>        </div>
        <div class="form_block">
            <p>Стоимость материалов:<span>канва, нитки, рамка и т.д.</span></p>
            <input type="text" id="EmbroideryCostForm_material_price" name="EmbroideryCostForm[material_price]"><label>руб</label>
            <div style="display:none" id="EmbroideryCostForm_material_price_em_" class="errorMessage"></div>        </div>
        <div class="clear"></div>
        <p id="form-header" class="form_header">
            <ins>+</ins>
            Дополнительная стоимость
            <span>(усложняющие элементы)</span>
        </p>
        <div class="form_big_block">
            <p class="children">Отметьте условия работы, которые будут входить в стоимость</p>

            <div>
            <p>
                <input type="checkbox" class="CheckBoxClass" id="ch1" name="EmbroideryCostForm[more_colors]" onclick="embroideryCost.activate(this, 'EmbroideryCostForm_colors_count')">
                <label class="CheckBoxLabelClass" for="ch1">
                    Если в схеме более 25 цветов, добавляем <span>1%</span> за каждый цвет
                </label>
            </p>
            </div>

            <div>
            <p class="children">

                <label>Количество цветов в схеме:</label>
                <input type="text" id="EmbroideryCostForm_colors_count" name="EmbroideryCostForm[colors_count]" disabled="disabled">                </p><div style="display:none" id="EmbroideryCostForm_colors_count_em_" class="errorMessage"></div>            <p></p>
            </div>

            <p>
                <input type="checkbox" class="CheckBoxClass" name="ch2" id="ch2">
                <label class="CheckBoxLabelClass" for="ch2">
                    Большое количество одиночных “крестиков” значительно усложняет процесс вышивки,
                    добавляем <span>20%</span>
                </label>
            </p>

            <p>
                <input type="checkbox" class="CheckBoxClass" name="ch3" id="ch3">
                <label class="CheckBoxLabelClass LabelSelected" for="ch3">
                    Темная канва, вышивка по которой значительно сложнее, добавляем <span>25%</span>
                </label>
            </p>

            <p>
                <input type="checkbox" class="CheckBoxClass" onclick="embroideryCost.activate(this, 'EmbroideryCostForm_canva')" name="EmbroideryCostForm[small_canva]" id="ch4">
                <label class="CheckBoxLabelClass LabelSelected" for="ch4">
                    Мелкая канва, добавляем <span>5-20%</span>
                    <ins>Аида 14 считается нормальным размером</ins>
                </label>
            </p>
            <div class="input-box">
                <span class="units">Размер канвы в схеме:</span>

                <select id="EmbroideryCostForm_canva" name="EmbroideryCostForm[canva]" class="chzn">
<option value="">-</option>
<option value="1">7</option>
<option value="2">11</option>
<option value="3">14</option>
<option value="5">16</option>
<option value="10">18</option>
<option value="15">20</option>
<option value="20">22</option>
<option value="25">25</option>
</select>
                <div class="clear"></div>
            </div>
            <p>
                <input type="checkbox" class="CheckBoxClass" name="ch5" id="ch5">
                <label class="CheckBoxLabelClass LabelSelected" for="ch5">
                    Срочный заказ, добавляем <span>25%</span>
                </label>
            </p>

            <p>
                <input type="checkbox" class="CheckBoxClass" name="ch6" id="ch6">
                <label class="CheckBoxLabelClass LabelSelected" for="ch6">
                    Наличие дополнительных элементов, добавляем <span>25%</span>
                    <ins>(бекстич, французские узелки, коучинг, бисер, ленты)</ins>
                </label>
            </p>
            <p>
                <input type="checkbox" class="CheckBoxClass" name="EmbroideryCostForm[user_design]" onclick="embroideryCost.activate(this, 'EmbroideryCostForm_design_price')" id="ch7">
                <label class="CheckBoxLabelClass LabelSelected" for="ch7">
                    Сами разрабатывали схему? Добавьте стоимость её разработки
                </label>
            </p>

            <div>
            <p class="children">
                <label>Стоимость вашего дизайна:</label>
                <input type="text" id="EmbroideryCostForm_design_price" name="EmbroideryCostForm[design_price]">                </p><div style="display:none" id="EmbroideryCostForm_design_price_em_" class="errorMessage"></div>            <p></p>
            </div>
        </div>

        <input type="submit" value="Рассчитать">

        <div style="display:none" class="errorSummary" id="embroideryCost-form_es_"><p>Необходимо исправить следующие ошибки:</p>
<ul><li>dummy</li></ul></div>        <div id="result">
        </div>
        </form>    </div>
</div>
<br><br>
<div class="wysiwyg-content">
    <h1>Расчёт стоимости вышивки</h1>

    <p>Вы вышивали долго и упорно картину. А теперь она так понравилась знакомой, что та готова купить её за любые
        деньги! Она-то готова, а вы сомневаетесь: и продешевить не хочется, и слишком высокую цену назначать
        неудобно.</p>

    <div class="brushed">
        <p>Воспользуйтесь независимым оценщиком &ndash; нашим сервисом по расчёту стоимости готовой вышивки. Для этого нужно
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
            <li>Если вы являетесь автором использованной схемы вышивки &ndash; прибавьте стоимость её разработки в рублях.
            </li>
        </ul>
        <p>После того как всё учтено &ndash; смело нажимайте на кнопку «рассчитать», и вы получите:</p>
        <ul>
            <li>стоимость основной работы,</li>
            <li>стоимость декоративных элементов,</li>
            <li>итоговую стоимость работы.</li>
        </ul>
    </div>
    <p>Теперь вы точно знаете, сколько стоит ваш труд!</p>
</div>    </div>
		</div>
		<div class="footer-push"></div>
		
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</body>
</html>
