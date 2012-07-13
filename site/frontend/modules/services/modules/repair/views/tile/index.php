<?php $this->meta_description = 'Ванная. Отделка плиткой этого помещения давно стала классикой. Но перед тем как купить плитку для ванной, нужно посчитать, сколько её понадобится. Это легко сделать, воспользовавшись нашим сервисом';
?><div id="repair-bathroom-tile">

    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'tile-calculate-form',
            'action' => $this->createUrl('tile/calculate'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'validateOnType' => false,
                'validationUrl' => $this->createUrl('tile/calculate'),
                'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Tile.Calculate();
                                return false;
                              }",
            )));

        $form->error($tileModel, 'wallLength');
        $form->error($tileModel, 'roomHeight');
        $form->error($tileModel, 'bathLength');
        $form->error($tileModel, 'bathHeight');
        $form->error($tileModel, 'doorHeight');
        $form->error($tileModel, 'doorWidth');
        $form->error($tileModel, 'tileLength');
        $form->error($tileModel, 'tileWidth');

        ?>

        <div class="title">
            <h1>Расчет плитки<span>для ванной комнаты</span></h1>

            <p>Вы можете самостоятельно рассчитать количество плиток, которое <br/>может понадобиться для отделки ванной
                комнаты. </p>

            <div class="red">Не забывайте про дополнительные 10% на резку и потери.</div>
        </div>

        <div class="form-in">

            <div class="row">

                <div class="img">
                    <div class="val" id="wallSq"></div>
                    <img src="/images/repair_bathroom_tile_01.gif"/>
                </div>

                <div class="row-line">
                    <div class="text">Длина всех стен</div> <?php echo $form->textField($tileModel, 'wallLength') ?>
                    <span>м</span>
                </div>

                <div class="row-line">
                    <div class="text">Высота стены</div> <?php echo $form->textField($tileModel, 'roomHeight') ?> <span>м</span>
                </div>

            </div>

            <div class="row error">
                <?php echo $form->error($tileModel, 'wallLength') . $form->error($tileModel, 'roomHeight');?>
            </div>

            <div class="row">

                <div class="img">
                    <div class="val" id="bathSq"></div>
                    <img src="/images/repair_bathroom_tile_02.gif"/>
                </div>

                <div class="row-line">
                    <div class="text">Длина ванны</div> <?php echo $form->textField($tileModel, 'bathLength') ?>
                    <span>м</span>
                </div>

                <div class="row-line">
                    <div class="text">Высота ванны</div> <?php echo $form->textField($tileModel, 'bathHeight') ?> <span>м</span>
                </div>

            </div>

            <div class="row error">
                <?php echo $form->error($tileModel, 'bathLength') . $form->error($tileModel, 'bathHeight');?>
            </div>

            <div class="row">

                <div class="img">
                    <div class="val" id="doorSq"></div>
                    <img src="/images/repair_bathroom_tile_03.gif"/>
                </div>

                <div class="row-line">
                    <div class="text">Ширина двери</div> <?php echo $form->textField($tileModel, 'doorWidth') ?>
                    <span>м</span>
                </div>

                <div class="row-line">
                    <div class="text">Высота двери</div> <?php echo $form->textField($tileModel, 'doorHeight') ?> <span>м</span>
                </div>

            </div>

            <div class="row error">
                <?php echo $form->error($tileModel, 'doorWidth') . $form->error($tileModel, 'doorHeight');?>
            </div>

            <div class="row">

                <div class="img">
                    <div class="val" id="tileSq"></div>
                    <img src="/images/repair_bathroom_tile_04.gif"/>
                </div>

                <div class="row-line">
                    <div class="text">Ширина плитки</div> <?php echo $form->textField($tileModel, 'tileWidth') ?> <span>м</span>
                </div>

                <div class="row-line">
                    <div class="text">Высота плитки</div> <?php echo $form->textField($tileModel, 'tileLength') ?>
                    <span>м</span>
                </div>

            </div>

            <div class="row error">
                <?php echo $form->error($tileModel, 'tileWidth') . $form->error($tileModel, 'tileLength');?>
            </div>

            <div class="row row-btn">
                <button onclick="$('#tile-calculate-form').submit(); event.preventDefault();">Рассчитать</button>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>

    <div class="recommendation clearfix" id="result">

        <div class="left">
            <img src="/images/img_repair_bathroom_tile.png"/><br/>Плитки потребуется: <span>455 штук</span>
        </div>

        <div class="right">
            <p>Именно столько плитки потребуется вам для того, чтобы  обклеить ванную комнату.</p>
            <p>Не забывайте про дополнительные 10% на резку и потери.</p>
        </div>

    </div>

    <div class="wysiwyg-content">

        <h3>Сервис «Расчет плитки для ванной комнаты»</h3>

        <p>Вы решили облицевать стены ванной комнаты плиткой и хотите провести расчет плитки для ванной? Задача сложная:
            стены этой комнаты редко бывают свободными, обычно их закрывают ванна, газовая колонка, короб для труб,
            встроенные шкафы и, возможно, что-то ещё. В одной из стен ванной комнаты находится дверь, в другой может
            быть окно... Приходится брать калькулятор, бумагу, ручку и проводить сложные математические вычисления.</p>

        <div class="brushed">
        <p>Предлагаем вам упростить этот процесс, воспользовавшись нашим сервисом. Вы просто по порядку вводите
            необходимые данные в специальную форму: длину и высоту стен ванной комнаты, размеры плитки, которую будете
            укладывать. Затем нужно учесть те пространства, на которых плитки не будет, обычно это дверь и окно. Для
            корректного расчёта вводимые вами размеры должны быть в метрах.</p>

        <p>Теперь нажимайте кнопку «Рассчитать», и вот результат – количество плиток, которое вам необходимо, чтобы
            покрыть ими стены ванной комнаты.</p>
        </div>

        <p>Совет: если стены вашей ванной комнаты имеют сложную конфигурацию, то выбирайте плитку небольшого размера.
            Это позволит произвести более точный расчет плитки для ванной и уменьшить количество отходов, возникающих в
            результате её обрезания.</p>

    </div>

</div>