<?php $this->meta_description = 'Сколько обоев нужно, чтобы оклеить одну комнату? А две? А если на обоях сложный рисунок? Воспользуйтесь нашим сервисом и узнайте точно, сколько нужно обоев для того, чтобы оклеить ими запланированное помещение';
?>
<div id="repair-wallpapers">

    <div class="form">

        <div class="title">
            <h1>Расчет количества обоев</h1>

            <p>Онлайн калькулятор для расчета количества обоев. Предварительный расчет обоев для комнаты позволит вам
                сэкономить при их покупке. </p>
        </div>

        <div class="form-in">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'wallpapers-calculate-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'action' => $this->createUrl('wallpapers/calculate'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('wallpapers/calculate'),
                    'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Wallpapers.StartCalc();
                                return false;
                              }",
                )));
            ?>
            <?php //echo $form->errorSummary($model) ?>

            <div class="row">
                <div class="row-title">Размер помещения <span>(в метрах)</span></div>
                <div class="row-elements">
                    <div class="col">Ширина <?php echo $form->textField($model, 'room_width') ?></div>
                    <div class="col">Длина <?php echo $form->textField($model, 'room_length') ?></div>
                    <div class="col">Высота <?php echo $form->textField($model, 'room_height') ?></div>
                </div>
                <?php
                echo $form->error($model, 'room_length');
                echo $form->error($model, 'room_width');
                echo $form->error($model, 'room_height');
                ?>
            </div>

            <div class="row">
                <div class="row-title">Размер обоев <span>(в метрах)</span></div>
                <div class="row-elements">
                    <div class="col">Ширина <?php echo $form->textField($model, 'wp_width') ?></div>
                    <div class="col">Длина <?php echo $form->textField($model, 'wp_length') ?></div>
                    <div class="col">Раппорт <?php echo $form->textField($model, 'repeat') ?></div>
                </div>
                <div class="small">Раппорт обоев - шаг между отдельными элементами рисунка</div>
                <?php
                echo $form->error($model, 'wp_width');
                echo $form->error($model, 'wp_length');
                echo $form->error($model, 'repeat');
                ?>
            </div>

            <?php $this->endWidget(); ?>


            <div class="row except">
                <div class="in">
                    <div class="cut"></div>
                    <big>Участки, которые не нужно обклеивать</big>
                    <a href="#" class="pseudo"
                       onclick="$('#empty-area-form').toggle(); $('#empty-area-form')[0].reset(); event.preventDefault();">Указать
                        участок</a>

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'empty-area-form',
                        'action' => $this->createUrl('wallpapers/addemptyarea'),
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'validateOnChange' => false,
                            'validateOnType' => false,
                            'validationUrl' => $this->createUrl('wallpapers/addemptyarea'),
                            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Wallpapers.AreaCreate();
                                return false;
                              }",
                        )));
                    ?>


                    <?php
                    $form->error($emptyArea, 'title');
                    $form->error($emptyArea, 'height');
                    $form->error($emptyArea, 'width');
                    ?>

                    <div class="except-area">
                        <div class="tale"></div>
                        <?php echo $form->textField($emptyArea, 'title', array('placeholder' => 'Введите название')) ?>
                        <?php echo $form->textField($emptyArea, 'height', array('placeholder' => 'Шир.')) ?>
                        <?php echo $form->textField($emptyArea, 'width', array('placeholder' => 'Выс.')) ?>
                        <?php echo $form->textField($emptyArea, 'qty', array('placeholder' => 'Кол-во')) ?>

                        <a href="#" class="btn btn-green-small"
                           onclick="$('#empty-area-form').submit(); event.preventDefault();">
                            <span><span>Ok</span></span>
                        </a>

                        <div class="clear"></div>
                        <?php echo $form->errorSummary($emptyArea) ?>
                    </div>

                    <?php $this->endWidget(); ?>

                    <ul id="emptyareas">
                    </ul>
                </div>
            </div>

            <div class="row row-btn">
                <button onclick="$('#wallpapers-calculate-form').submit(); return false;">Рассчитать</button>
            </div>

        </div>

    </div>

    <div class="recommendation clearfix" id="result">

        <div class="left">
            <img src="/images/services/img_repair_wallpapers.png"/><br/>Нужно не менее <span>6 рулонов</span>
        </div>

        <div class="right">
            <p>Чтобы оклеить это помещение выбранными вами обоями, потребуется <span></span>. Внимание: если в комнате
                много углов, сложных стыков и неоклеиваемых мест, заложите 10 – 15% материалов на подгонку.</p>
        </div>

    </div>

    <div class="wysiwyg-content">

        <h3>Сервис «Расчет количества обоев»</h3>

        <p>Каждый, кто хотя бы однажды сталкивался с необходимостью поменять обои в комнате, знает, что сама процедура
            оклейки стен не такая уж сложная. Главное – правильно подготовиться, в том числе купить нужное количество
            обоев.</p>

        <p>Чтобы сделать правильный расчет обоев, нужно учесть все факторы. При этом даже если вы дружите с математикой,
            всегда существует вероятность что-либо упустить. Если расчет обоев будет неточным – есть риск купить их
            больше или меньше необходимого количества. Лишние обои – это лишние потраченные деньги, иногда немалые. А
            вот недостаток обоев часто грозит серьёзными проблемами. Купленные обои могут оказаться не того оттенка, а
            это часто обнаруживается только на стене. Нужный оттенок можно искать много дней и не найти. Придётся
            выкручиваться, выдумывая новый дизайн комнаты, либо снимать уже наклеенные обои и заменять их теми, которые
            есть в достаточном количестве.</p>

        <div class="brushed">
            <p>Чтобы расчет количества обоев был верным, воспользуйтесь нашим сервисом. Просто введите длину, ширину и
                высоту оклеиваемых стен, затем учтите ширину рулона обоев и места, ширину раппорта рисунка и наличие
                сдвига,
                прибавьте запас на выравнивание. Учтите места, которые вы не будете оклеивать (например, окно, дверь).
                Заполнив форму, нажмите кнопку «рассчитать». Через секунду вы получите точный расчет количества обоев,
                которое вам понадобится.</p>
        </div>
    </div>

</div>