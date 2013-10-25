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
    <div class="calculator_loops">
        <h1>Калькулятор петель</h1>

        <form method="post" action="/sewing/loopCalculator/" id="loop-calculator-form">
        <div class="form_block green">
            <p class="form_header">Размер образца</p>

            <p>Введите размер образца и количество рядов и петель в нем:</p>

            <div class="left_column">
                <p>Ширина</p>

                <div class="row">
                    <input type="text" id="LoopCalculationForm_sample_width_sm" name="LoopCalculationForm[sample_width_sm]">                    <div style="display:none" id="LoopCalculationForm_sample_width_sm_em_" class="errorMessage"></div><label>см</label>
                </div>
                <div class="row">
                    <input type="text" id="LoopCalculationForm_sample_width_p" name="LoopCalculationForm[sample_width_p]">                    <div style="display:none" id="LoopCalculationForm_sample_width_p_em_" class="errorMessage"></div><label>петель</label>
                </div>
            </div>
            <div class="right_column">
                <p>Длина</p>

                <div class="row">
                    <input type="text" id="LoopCalculationForm_sample_height_sm" name="LoopCalculationForm[sample_height_sm]">                    <div style="display:none" id="LoopCalculationForm_sample_height_sm_em_" class="errorMessage"></div><label>см</label>
                </div>
                <div class="row">
                    <input type="text" id="LoopCalculationForm_sample_height_p" name="LoopCalculationForm[sample_height_p]">                    <div style="display:none" id="LoopCalculationForm_sample_height_p_em_" class="errorMessage"></div><label>рядов</label>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="form_block blue">
            <p class="form_header">Размер изделия</p>

            <p>Введите размер изделия</p>

            <div class="left_column">
                <p>Ширина</p>

                <div class="row">
                    <input type="text" id="LoopCalculationForm_width" name="LoopCalculationForm[width]">                    <div style="display:none" id="LoopCalculationForm_width_em_" class="errorMessage"></div><label>см</label>
                </div>
            </div>
            <div class="right_column">
                <p>Длина</p>

                <div class="row">
                    <input type="text" id="LoopCalculationForm_height" name="LoopCalculationForm[height]">                    <div style="display:none" id="LoopCalculationForm_height_em_" class="errorMessage"></div><label>см</label>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <input type="submit" value="Рассчитать">

        <div id="result">
        </div>

        <div style="display:none" class="errorSummary" id="loop-calculator-form_es_"><p>Необходимо исправить следующие ошибки:</p>
<ul><li>dummy</li></ul></div>
        <div class="clear"></div>

        </form>    </div>
</div>
<br><br>
<div class="wysiwyg-content">
    <h1>Калькулятор петель</h1>

    <p>Начинаете вязать себе носок, делаете несколько рядов и понимаете, что он будет мал даже младшей дочке.
        Распускаете. Прибавляете несколько петель на каждой спице и начинаете заново. Через полчаса понимаете, что носок
        будет велик даже дедушке. Бывало у вас так?</p>

    <div class="brushed">
        <p>Чтобы подобной ситуации не возникало &ndash; создан наш сервис. Пользоваться им просто.</p>

        <p>Сначала нужно связать образец из выбранной пряжи в виде квадрата со сторонами примерно 12 сантиметров. Его
            нужно намочить, высушить, не растягивая, и чуть-чуть отпарить. Берём линейку &ndash; отмеряем, слегка отступив от
            края, 10 сантиметров в ширину и считаем, сколько в них поместилось петель. Потом измеряем длину и считаем,
            сколько в ней поместилось рядов. Если у вас получился образец меньшего размера &ndash; ничего страшного.
            Посчитайте, сколько петель и рядов помещается в 8 сантиметрах или даже в 5.</p>

        <p>Теперь всё просто.</p>
        <ul>
            <li>Вводим полученные данные в соответствующие поля специальной формы,</li>
            <li>Вводим желаемые длину и ширину изделия в специальные поля формы.</li>
        </ul>
        <p>Получаем результат: сколько нужно набрать петель, чтобы получилась необходимая ширина изделия, и сколько
            нужно провязать рядов, чтобы достичь нужной длины изделия.</p>
    </div>
    <p>Теперь нужный размер любого изделия, даже намного более сложного, чем носок, получится с первого раза. А это так
        приятно!</p>
</div>    </div>
        </div>
        
        <div class="footer-push"></div>
        
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
</body>
</html>
