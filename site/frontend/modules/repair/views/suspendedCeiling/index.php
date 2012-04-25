<div id="repair-ceiling">

    <div class="form">

        <div class="title">
            <h1>Расчет количества обоев</h1>
            <span>ПОДВЕСНОГО ПОТОЛКА</span>
            <p>Калькулятор поможет Вам рассчитать cколько надо материалов (потолочной плитки, реек, подвесов) для плиточного подвесного потолка.</p>
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

            <?php echo $form->error($SuspendedCeilingModel, 'area'); ?>

            <div class="row">

                <big>Площадь потолка</big> <?php echo $form->textField($SuspendedCeilingModel, 'area') ?> <b>м</b><sup>2</sup>

                <div class="small"><span>Потолочная плитка</span>
                    <?php echo $form->dropDownList($SuspendedCeilingModel, 'plate', $SuspendedCeilingModel->plateTypes, array('class'=>'chzn')) ?>
                </div>

            </div>

            <div class="row row-btn">
                <button onclick="$('#SuspendedCeiling-calculate-form').submit(); return false;">Рассчитать</button>
            </div>

            <?php $this->endWidget(); ?>

            <div class="row row-result" style="display:none">

                <!--<div class="title">Материалов потребуется</div>

                <ul>
                    <li>
                        <span class="count">84&nbsp; шт.</span>
                        <span>Потолочная плитка</span>
                    </li>
                    <li>
                        <span class="count">15&nbsp; шт.</span>
                        <span>Подвес</span>
                    </li>
                    <li>
                        <span class="count">5&nbsp; шт.</span>
                        <span>Рейка - 3 м</span>
                    </li>
                    <li>
                        <span class="count">6&nbsp; шт.</span>
                        <span>Рейка несущая - 3.6 м</span>
                    </li>
                    <li>
                        <span class="count">39&nbsp; шт.</span>
                        <span>Рейка - 0.6 м</span>
                    </li>
                    <li>
                        <span class="count">39&nbsp; шт.</span>
                        <span>Рейка - 1.2 м</span>
                    </li>
                </ul>

                <div style="text-align:right;"><a href="" class="pseudo">Прочитать рекомендации</a></div>
                -->

            </div>



        </div>

    </div>

    <div class="recommendation clearfix">

        <p>Рассчитанное количество материалов является точным для потолка правильной прямоугольной формы. Если ваш потолок имеет сложную форму, то возьмите материалы с запасом от 10 до 25%.</p>

    </div>

    <div class="wysiwyg-content">

        <h3>Сервис «Расчет материалов для подвесного потолка»</h3>

        <p>Подвесной потолок – это стильно и удобно. Именно при помощи подвесного потолка можно выровнять самую кривую поверхность, портящую настроение всякий раз, когда вы ложитесь отдохнуть. Подвесным потолком можно не только замаскировать неровности, провода и шнуры, но ещё и сделать прекрасное, уникальное освещение комнаты. В общем, подвесной потолок – отличное изобретение современности!</p>

        <p>После принятия решения о том, что этой конструкции в вашем доме быть, нужно приобрести необходимые материалы, а сначала провести расчет подвесного потолка. Он достаточно сложен, так как нужно высчитать площадь потолка, количество потолочной плитки, реек и подвесов. Поэтому расчет подвесного потолка проводит специалист. То есть он должен сначала посетить вас с целью замеров и расчетов, а потом уже – для непосредственной работы.</p>

        <p>А что делать, если хочется быстрее? Обратите внимание на наш новый сервис, в который заложена программа расчета подвесного потолка. Для того чтобы ею воспользоваться, вам необходимо знать площадь потолка и название плитки, которую собираетесь использовать.</p>

        <p>Вы вводите эти данные в метрах и получаете список того, что нужно приобрести, а также количество всех необходимых материалов.</p>

        <p>Наша программа расчета подвесного потолка существенно экономит ваше время, исключая этап расчета материалов для потолка мастером, а значит, позволит быстрее осуществить задуманное.</p>



    </div>

</div>