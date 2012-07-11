<?php $this->meta_description = 'Перед тем как купить линолеум, паркет или ламинат, нужно сделать расчет: сколько этих материалов понадобится, чтобы покрыть ими нужную площадь пола в помещении? Считайте при помощи нашего сервиса и покупайте столько, сколько нужно';
?><div id="repair-floor">

    <div class="form">

        <div class="title">
            <h1>Расчет <span>напольного покрытия</span></h1>
            <p>Калькулятор рассчитывает необходимое количество плитки, линолеума, <br/>паркета, ламината, ковролина и т.д. для покрытия пола.</p>
        </div>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'flooring-calculate-form',
            'action' => $this->createUrl('flooring/calculate'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'validateOnType' => false,
                'validationUrl' => $this->createUrl('flooring/calculate'),
                'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Flooring.Calculate();
                                return false;
                              }",
            )));
        ?>

        <?php
        $form->error($FlooringModel, 'flooringLength');
        $form->error($FlooringModel, 'flooringWidth');
        $form->error($FlooringModel, 'floorWidth');
        $form->error($FlooringModel, 'floorLength');
        ?>
        <div class="form-in">

            <input type="hidden" name="t" value="<?=$FlooringModel->t?>">

            <div class="row">
                <big>Тип покрытия</big>
                <?php echo $form->dropDownList($FlooringModel, 'flooringType', $FlooringModel->flooringTypes, array('onchange'=>'Flooring.typeChanged($(this)); return false;', 'class'=>'chzn') ) ?>
            </div>

            <div class="row">
                <div class="row-elements">
                    <div class="row-line"><div class="text">Длина покрытия</div><?php echo $form->textField($FlooringModel, 'flooringLength') ?> м</div>
                    <div class="row-line"><div class="text">Ширина покрытия</div><?php echo $form->textField($FlooringModel, 'flooringWidth') ?> м</div>
                </div>
            </div>

            <div class="row">
                <div class="row-elements">
                    <div class="row-line"><div class="text">Длина пола</div><?php echo $form->textField($FlooringModel, 'floorWidth') ?> м</div>
                    <div class="row-line"><div class="text">Ширина пола</div><?php echo $form->textField($FlooringModel, 'floorLength') ?> м</div>
                </div>
                <?php echo $form->errorSummary($FlooringModel) ?>
            </div>



            <div class="row row-btn">
                <button onclick="$('#flooring-calculate-form').submit(); event.preventDefault();">Рассчитать</button>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>

    <div class="recommendation clearfix" id="result" style="display:none">

        <div class="left">
            Минимальный расход <span>72 штуки</span>
        </div>

        <div class="right">
            <p>Рассчитанное количество напольного материала является среднестатистическим. Всегда учитывайте особенности вашего материала и вашего помещения. Если пол имеет сложную конфигурацию, то прибавьте 10% на правильную подгонку выбранного материала.</p>
        </div>

    </div>

    <div class="wysiwyg-content seo-text">

        <h3>Сервис «Расчет напольного покрытия»</h3>

        <p>Вы решили, что пора заменить старое покрытие на полу новым, и теперь пытаетесь подсчитать, сколько же материалов вам потребуется? Это правильно: сначала нужно произвести точный расчет плитки, линолеума, паркетной доски, ламината – то есть того материала, который вы решили положить на пол.</p>

        <p>Хорошо, если вы определились с видом напольного покрытия. А если ещё нет? Придется сделать расчет плитки, ламината и паркетной доски отдельно. При этом нужно учесть все нюансы. Если вы любитель математики, то, возможно, это для вас не составит большого труда, может быть, даже принесет удовольствие. Но у большинства людей присутствует страх сделать расчет плитки или любого другого напольного покрытия неправильно.</p>

        <div class="brushed">
        <p>Специально для них – наш новый сервис – программа для расчета плитки, линолеума, ковролина, паркета и ламината. Пользоваться ею очень просто: выберите материал, который вы будете использовать в качестве напольного покрытия, введите длину и ширину выбранного материала в метрах, длину и ширину комнаты, в которой он будет использован в метрах, и нажмите кнопку «Рассчитать». Через секунду вы получите точный результат.</p>

        <p>Таким образом, за одну секунду вы можете рассчитать количество практически всех напольных материалов и отправиться в магазин – выбирать подходящий. Программа для расчета плитки и другого напольного покрытия позволит быстро приступить к практической части работы с уверенностью в том, что материалов будет куплено ровно столько, сколько нужно.</p>

        </div>

    </div>

</div>