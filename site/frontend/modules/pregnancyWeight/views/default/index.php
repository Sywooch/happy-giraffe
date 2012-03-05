<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$js = "$('.pregnancy-weight-form button').click(function(data){
            $('#pregnant-params-form').submit();
            return false;
        });
        function StartCalc(){
            $.ajax({
                url: " . CJSON::encode(Yii::app()->createUrl("/pregnancyWeight/default/calculate")) . ",
                data: $('#pregnant-params-form').serialize(),
                type: 'POST',
                success: function(data) {
                    $('.intro-text').hide();
                    $('#result').html(data);
                    $('html,body').animate({scrollTop: $('#result').offset().top},'fast');
                }
            });
        }
        $('#baby').delegate('.go-weight-table', 'click', function () {
            $('#recommend').hide();
            $('#weight-table').show();
            return false;
        });
        $('#baby').delegate('.go-recommend-table', 'click', function () {
            $('#recommend').show();
            $('#weight-table').hide();
            return false;
        });
";
Yii::app()->clientScript->registerScript('pregnancy-weight', $js);

?>
<div class="section-banner" style="margin:0;">

    <img src="/images/section_banner_05.jpg"/>

    <div class="pregnancy-weight-form">
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'pregnant-params-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('/pregnancyWeight/default/calculate'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                return false;
                              }",
        )));
        $model = new PregnantParamsForm();
        ?>
        <div class="row">
            <span>Мой рост:</span>

            <div class="input-box">
                <?php echo $form->textField($model, 'height'); ?>
                <span class="units">см</span>
            </div>
            <?php echo $form->error($model, 'height'); ?>
        </div>
        <div class="row">
            <span>Мой вес до беременности:</span>

            <div class="input-box">
                <?php echo $form->textField($model, 'weight_before'); ?>
                <span class="units">кг</span>
            </div>
            <?php echo $form->error($model, 'weight_before'); ?>
        </div>
        <img src="/images/pregnancy_weight_form_sep.png"/>

        <div class="row">
            <span>Мой срок беременности:</span>

            <div class="input-box">
                <?php echo $form->dropDownList($model, 'week',
                HDate::Range(1, 40),
                array(
                    'class'=>'chzn pregnancy_term',
                    'empty'=>'-'
                )); ?>
                <span class="units">нед</span>
            </div>
            <?php echo $form->error($model, 'week'); ?>
        </div>
        <div class="row">
            <span>Сейчас мой вес:</span>

            <div class="input-box">
                <?php echo $form->textField($model, 'weight'); ?>
                <span class="units">кг</span>
            </div>
            <?php echo $form->error($model, 'weight'); ?>
        </div>
        <button>Рассчитать<br/>прибавку</button>
        <?php $this->endWidget(); ?>
    </div>

</div>

<div class="block-in" id="result">

</div>
<div class="seo-text">
    <h1 class="summary-title">Прибавка веса: беременность</h1>

    <p>Наступление беременности сопровождается значительными изменениями в организме женщины. Это и понятно: теперь ему
        приходится работать, как говорят в народе, &laquo;за двоих&raquo;. Увеличивается слой подкожно-жировой
        клетчатки, которая является своеобразным &laquo;депо&raquo; воды, питательных веществ и витаминов для
        благополучного развития ребенка. Но это не единственный фактор, влияющий на вес во время беременности.
        Рассмотрим данный вопрос подробнее.</p>

    <h3>Вес при беременности увеличивается, потому что:</h3>
    <ul>
        <li>растет плодное яйцо (плод + плодные оболочки),</li>
        <li>развивается плацента,</li>
        <li>увеличивается вес и размеры матки (как собственно мышечной ткани, так и околоплодных вод),</li>
        <li>изменяется толщина подкожно-жирового слоя,</li>
        <li>увеличиваются молочные железы.</li>
    </ul>

    <h3>На вес при беременности влияют:</h3>
    <ul>
        <li>Возраст: чем старше женщина, тем больший вес во время беременности она набирает.</li>
        <li>Самочувствие. При токсикозе на раннем сроке и частой рвоте женщина может похудеть, а при токсикозе на
            последних месяцах беременности, сопровождающемся нефропатией и отеками, вес быстро нарастает.
        </li>
        <li>Многоплодная беременность &ndash; понятно, что два или три ребенка весят больше, чем один.</li>
        <li>Патологическое течение беременности, например многоводие при внутриутробных инфекциях или отеки при
            сопутствующих заболеваниях почек.
        </li>
        <li>Индекс массы тела (ИМТ) до беременности. ИМТ &ndash; это отношение веса женщины в килограммах к квадрату ее
            роста в метрах. Чем меньше ИМТ, тем обычно больше прибавка веса.
        </li>
    </ul>

    <h3>Существуют ли стандарты набора веса при беременности?</h3>

    <p>Да, существуют. Однако нужно помнить: набор веса беременными индивидуален и зависит от многих факторов. Очевидно,
        что полная женщина и совсем худенькая, крупная и миниатюрная наберут разное количество килограммов. Поэтому вес
        во время беременности оценивают по специальным таблицам, опираясь на ИМТ.</p>

    <h3>Чем опасна низкая прибавка веса?</h3>

    <p>Малый набор массы тела при беременности опасен тем, что ребенок будет получать недостаточное количество
        питательных веществ и начнет отставать в своем развитии.</p>

    <p>Не секрет, что каждый день внутриутробного развития очень важен для малыша, и любая задержка негативно скажется
        на его здоровье.</p>

    <h3>Чем опасна высокая прибавка массы тела?</h3>

    <p>Чаще всего лишний вес обусловлен многоводием и отеками во время беременности. Эти состояния достаточно опасны.
        При таких симптомах обычно женщину госпитализируют, чтобы провести коррекционное лечение.</p>

    <h3>Какой набор веса считается идеальным?</h3>

    <p>Идеальна плавная прибавка веса, беременность при которой течет оптимально, то есть ребенок развивается нормально,
        получая все необходимое от матери.</p>

    <div class="brushed">
        <h3>Наш сервис поможет понять, какой график набора веса является идеальным именно для вас, разобраться в тех
            причинах, которые могли бы это обусловить, и принять своевременные меры.</h3>

        <h3>Что нужно сделать:</h3>
        <ul style="list-style-type: decimal;">
            <li>Аккуратно заполнить специальные окошки, последовательно введя свой рост в сантиметрах, вес до
                беременности в килограммах, срок беременности в неделях и свой вес в настоящее время в килограммах.
            </li>
            <li>Нажать кнопку &laquo;рассчитать прибавку&raquo;.</li>
            <li>После этого вы узнаете, является ваш вес идеальным, больше нормы или меньше. Вы также можете перейти на
                страницу, где представлена таблица набора веса на каждой неделе, составленная индивидуально для вас!
            </li>
        </ul>
    </div>
</div>