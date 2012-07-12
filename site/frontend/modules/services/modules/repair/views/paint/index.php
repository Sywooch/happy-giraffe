<?php $this->meta_description = 'Краска практически всегда используется при проведении ремонтных работ. Сделайте точный расчет краски и узнайте, сколько её понадобится для покрытия конкретной поверхности в один слой при помощи нашего нового сервиса. Заходите!';
?><div id="repair-paint">

    <div class="form">

        <div class="title">
            <h1>Расчет объема краски</h1>
            <span>Рассчитаем вместе</span>
            <p>Калькулятор поможет вам рассчитать расход краски при окраске стен, а также потолка и пола в один слой.</p>
        </div>

        <div class="form-in">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'paint-calculate-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'action' => $this->createUrl('paint/calculate'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('paint/calculate'),
                    'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Paint.Calculate();
                                return false;
                              }",
                )));
            ?>

            <div class="row-switcher">
                <div class="a-right">Посчитать для
                    <span data-title="Стены" style="display:none"><a href="" class="pseudo" onclick="return Paint.SurfaceSwitch(this);">стен</a></span>
                    <span data-title="Потолок"><a href="" class="pseudo" onclick="return Paint.SurfaceSwitch(this);">потолка</a></span>
                    <span data-title="Пол"><a href="" class="pseudo" onclick="return Paint.SurfaceSwitch(this);">пола</a></span>
                </div>
                <big>Стены</big>
            </div>

            <div class="row">
                <div class="row-title"><big>Тип краски</big>
                    <?php echo $form->dropDownList($model, 'paintType', $model->paints, array('class'=>'chzn') ) ?>
                </div>
            </div>

            <div class="row">

                <?php
                $form->error($model, 'roomWidth');
                $form->error($model, 'roomLength');
                $form->error($model, 'roomHeight');
                ?>

                <div class="row-title">Размер помещения <span>(в метрах)</span></div>
                <div class="row-elements">
                    <?php echo $form->hiddenField($model, 'surface', array('value'=>'Стены')) ?>
                    <div class="col">Ширина<br/><?php echo $form->textField($model, 'roomWidth') ?></div>
                    <div class="col">Длина<br/><?php echo $form->textField($model, 'roomLength') ?></div>
                    <div class="col">Высота<br/><?php echo $form->textField($model, 'roomHeight') ?></div>
                    <?php echo $form->errorSummary($model) ?>
                </div>
            </div>

            <?php $this->endWidget(); ?>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'empty-area-form',
                'action' => $this->createUrl('paint/addemptyarea'),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => false,
                    'validateOnType' => false,
                    'validationUrl' => $this->createUrl('paint/addemptyarea'),
                    'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Paint.AreaCreate();
                                return false;
                              }",
                )));
            ?>
            <div class="row except">
                <div class="in">
                    <?php
                    $form->error($emptyArea, 'title');
                    $form->error($emptyArea, 'height');
                    $form->error($emptyArea, 'width');
                    ?>
                    <big>Участки, которые не нужно красить</big>
                    <a href="" class="pseudo" onclick="$('.except-area').toggle(); $('#empty-area-form')[0].reset(); event.preventDefault();">Указать участок</a>
                    <span>(Например, дверь, окно и другие)</span>
                    <div class="except-area">
                        <div class="tale"></div>
                        <?php echo $form->textField($emptyArea, 'title', array('placeholder' => 'Введите название')) ?>
                        <?php echo $form->textField($emptyArea, 'height', array('placeholder' => 'Шир.')) ?>
                        <?php echo $form->textField($emptyArea, 'width', array('placeholder' => 'Выс.')) ?>
                        <?php echo $form->textField($emptyArea, 'qty', array('placeholder' => 'Кол-во')) ?>
                        <a class="btn btn-green-small" onclick="$('#empty-area-form').submit(); event.preventDefault();"><span><span>Ok</span></span></a>
                        <?php echo $form->errorSummary($emptyArea) ?>
                    </div>

                    <ul id="emptyareas">
                    </ul>

                </div>
            </div>
            <?php $this->endWidget(); ?>

            <div class="row row-btn">
                <button onclick="$('#paint-calculate-form').submit(); event.preventDefault();">Рассчитать</button>
            </div>

        </div>

    </div>

    <div class="recommendation clearfix" id="result" style="display:none">

        <div class="left">
            <img src="/images/img_repair_paint_side.png" data-title="Стены" />
            <img src="/images/img_repair_paint_up.png" data-title="Потолок" style="display: none;" />
            <img src="/images/img_repair_paint_down.png" data-title="Пол" style="display: none;" />
            <br/><div>Краски для стен нужно</div> <span>9 литров</span>
        </div>

        <div class="right">
            <p>Именно столько краски понадобится, чтобы покрыть ею рассчитанную поверхность помещения в один слой.</p>
        </div>

    </div>

    <div class="wysiwyg-content">

        <h3>Сервис «Расчет объема краски»</h3>

        <p>Вам нужно покрасить стены или какую-то другую поверхность и интересно знать, сколько краски нужно купить?</p>

        <p>Конечно, некоторые производители пишут на этикетке, сколько красящего средства идёт на один квадратный метр или на какую площадь поверхности хватает одной банки краски, но это помогает мало – всё равно нужно с калькулятором произвести расчет краски, необходимой для покрытия определенной поверхности.</p>

        <p>А если поверхность сложная и включает в себя окна, двери и другие неокрашиваемые участки – расчет расхода краски усложняется.</p>

        <div class="brushed">
            <p>Но не стоит грустить: на нашем сайте каждому человеку доступен сервис «Расчет расхода краски», с помощью которого расчет краски значительно упрощается. Все просто: выбираете краску по типу, вводите последовательно в необходимые окошки ширину, длину и высоту стен в метрах, указываем участки, которые не будем окрашивать (дверь, окна), в метрах. После этого нажимаете кнопку «Рассчитать».</p>
        </div>
        <p>В результате вы практически мгновенно узнаете, сколько литров краски понадобится, чтобы покрыть ею выбранную поверхность в один слой. Если вы планируете окрашивать помещение краской в два слоя – удвойте полученный результат.</p>

    </div>

</div>