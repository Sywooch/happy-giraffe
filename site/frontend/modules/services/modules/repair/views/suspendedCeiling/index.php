<?php
$this->meta_description = 'Подвесные потолки – это очень красиво, удобно и функционально. Хотите узнать, сколько материалов вам понадобится, особенно если вы задумали сделать подвесной потолок своими руками? Наш сервис к вашим услугам!';
?><div id="repair-ceiling">

    <div class="form">

        <div class="title">
            <h1>Расчет материалов для</h1>
            <span>ПОДВЕСНОГО ПОТОЛКА</span>

            <p>Калькулятор поможет вам рассчитать cколько надо материалов (потолочной плитки, реек, подвесов) для
                плиточного подвесного потолка.</p>
        </div>

        <div class="form-in">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'SuspendedCeiling-calculate-form',
                'action' => $this->createUrl('suspendedCeiling/calculate'),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('suspendedCeiling/calculate'),
                    'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    SuspendedCeiling.Calculate();
                                return false;
                              }",
                )));
            ?>

            <div class="row">

                <div>
                <big>Площадь потолка</big> <?php echo $form->textField($SuspendedCeilingModel, 'area') ?>
                <b>м</b><sup>2</sup>
                    <?php echo $form->error($SuspendedCeilingModel, 'area'); ?>
                </div>
                <div class="small"><span>Потолочная плитка</span>
                    <?php echo $form->dropDownList($SuspendedCeilingModel, 'plate', $SuspendedCeilingModel->plateTypes, array('class' => 'chzn')) ?>
                </div>

            </div>

            <div class="row row-btn">
                <button onclick="$('#SuspendedCeiling-calculate-form').submit(); return false;">Рассчитать</button>
            </div>

            <?php $this->endWidget(); ?>

            <div class="row row-result" id="result" style="display:none">


            </div>


        </div>

    </div>



    <div class="wysiwyg-content">

        <h3>Сервис «Расчет материалов для подвесного потолка»</h3>

        <p>Подвесной потолок – это стильно и удобно. Именно при помощи подвесного потолка можно выровнять самую кривую
            поверхность, портящую настроение всякий раз, когда вы ложитесь отдохнуть. Подвесным потолком можно не только
            замаскировать неровности, провода и шнуры, но ещё и сделать прекрасное, уникальное освещение комнаты. В
            общем, подвесной потолок – отличное изобретение современности!</p>

        <p>После принятия решения о том, что этой конструкции в вашем доме быть, нужно приобрести необходимые материалы,
            а сначала провести расчет подвесного потолка. Он достаточно сложен, так как нужно высчитать площадь потолка,
            количество потолочной плитки, реек и подвесов. Поэтому расчет подвесного потолка проводит специалист. То
            есть он должен сначала посетить вас с целью замеров и расчетов, а потом уже – для непосредственной
            работы.</p>

        <div class="brushed">
            <p>А что делать, если хочется быстрее? Обратите внимание на наш новый сервис, в который заложена программа
                расчета подвесного потолка. Для того чтобы ею воспользоваться, вам необходимо знать площадь потолка и
                название плитки, которую собираетесь использовать.</p>

            <p>Вы вводите эти данные в метрах и получаете список того, что нужно приобрести, а также количество всех
                необходимых материалов.</p>
        </div>

        <p>Наша программа расчета подвесного потолка существенно экономит ваше время, исключая этап расчета материалов
            для потолка мастером, а значит, позволит быстрее осуществить задуманное.</p>


    </div>

</div>