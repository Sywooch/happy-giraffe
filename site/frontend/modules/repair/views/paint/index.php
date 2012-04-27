<div id="repair-paint">

    <div class="form">

        <div class="title">
            <h1>Расчет объема краски</h1>
            <span>Рассчитаем вместе</span>
            <p>Калькулятор поможет Вам рассчитать расход краски при окраске стен, а также потолка и пола в один слой.</p>
        </div>

        <div class="form-in">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'wallpapers-calculate-form',
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
                                    Wallpapers.StartCalc();
                                return false;
                              }",
                )));
            ?>

            <div class="row-switcher">
                <div class="a-right">Посчитать для <a href="" class="pseudo">потолка</a> | <a href="" class="pseudo">пола</a></div>
                <big>Стены</big>
            </div>

            <div class="row">
                <div class="row-title"><big>Тип краски</big>
                    <?php echo $form->dropDownList($model, 'flooringType', $model->paints ) ?>
                </div>
            </div>

            <div class="row">

                <div class="row-title">Размер помещения <span>(в метрах)</span></div>
                <div class="row-elements">
                    <div class="col">Ширина<br/><input type="text" /></div>
                    <div class="col">Длина<br/><input type="text" /></div>
                    <div class="col">Высота<br/><input type="text" /></div>
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
                    <span>(Например дверь, окно и другие)</span>
                    <div class="except-area">
                        <div class="tale"></div>
                        <?php echo $form->textField($emptyArea, 'title', array('placeholder' => 'Введите название')) ?>
                        <?php echo $form->textField($emptyArea, 'height', array('placeholder' => 'Шир.')) ?>
                        <?php echo $form->textField($emptyArea, 'width', array('placeholder' => 'Выс.')) ?>
                        <?php echo $form->textField($emptyArea, 'qty', array('placeholder' => 'Кол-во')) ?>
                        <!--<input type="text" placeholder="Введите название" style="width:95px;" />
                        <input type="text" placeholder="Шир." style="width:30px;" />
                        <input type="text" placeholder="Выс." style="width:30px;" />
                        <input type="text" placeholder="Кол-во" style="width:40px;" />-->
                        <a class="btn btn-green-small" onclick="$('#empty-area-form').submit(); event.preventDefault();"><span><span>Ok</span></span></a>
                        <?php echo $form->errorSummary($emptyArea) ?>
                    </div>

                    <ul id="emptyareas">
                    </ul>

                </div>
            </div>
            <?php $this->endWidget(); ?>

            <div class="row row-btn">
                <button>Рассчитать</button>
            </div>

        </div>

    </div>

    <div class="recommendation clearfix">

        <div class="left">
            <img src="/images/img_repair_paint_side.png" /><br/><img src="/images/img_repair_paint_up.png" /><br/><img src="/images/img_repair_paint_down.png" /><br/>Краски для стен нужно <span>9 литров</span>
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

        <p>Но не стоит грустить: на нашем сайте каждому человеку доступен сервис «Расчет расхода краски», с помощью которого расчет краски значительно упрощается. Все просто: выбираете краску по типу, вводите последовательно в необходимые окошки ширину, длину и высоту стен в метрах, указываем участки, которые не будем окрашивать (дверь, окна) в метрах. После этого нажимаете кнопку «Рассчитать».</p>

        <p>В результате вы практически мгновенно узнаете, сколько литров краски понадобится, чтобы покрыть ею выбранную поверхность в один слой. Если вы планируете окрашивать помещение краской в два слоя – удвойте полученный результат.</p>

    </div>

</div>