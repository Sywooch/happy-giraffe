<?php

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/fabricCalculator.js', CClientScript::POS_HEAD);
$this->meta_description = 'Вам очень понравилась схема для вышивки, но она продаётся отдельно, и теперь нужно рассчитать, сколько нужно ткани для неё. Ткань или канва – купить их можно в любом магазине для рукодельниц, а сколько ткани нужно – подскажет наш сервис';
$model = new FabricCalculatorForm1();
?>
<div class="embroidery_service">
    <img src="/images/service_much_tissue.jpg" alt="" title=""/>

    <div class="tissue_left">
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'fabric-calculator-form1',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('fabricCalculator'),
            'afterValidate' => "js:function(form, data, hasError) {
                                    if (!hasError)
                                        fabricCalculator.calc();
                                    else{
                                        $('#res').html('').hide();
                                    }
                                    return false;
                                  }",
        )));?>
        <div class="tissue_type">
            <span><ins>Для льна</ins>или другой ткани<br/>равномерного переплетения</span>

            <div class="style_rarr"></div>
            <!-- .style_rarr -->
        </div>
        <!-- .tissue_type -->
        <div class="tissue_calc">
            <ul>
                <li class="hide-div">
                    <ins>Введите размер схемы<br/> в стежках:</ins>
                    <div>
                        Ширина <?php echo $form->textField($model, 'width', array('class' => 'wh_t')) ?>
                        <?php echo $form->error($model, 'width'); ?>
                    </div>
                    <div>
                    Высота <?php echo $form->textField($model, 'height', array('class' => 'wh_t')) ?>
                        <?php echo $form->error($model, 'height'); ?>
                    </div>
                </li>
                <li>
                    <div>
                        <ins>Введите количество нитей для <br/>одного "креста":
                            <?php echo $form->textField($model, 'threads_num', array('class' => 'much_t')) ?>
                            <?php echo $form->error($model, 'threads_num'); ?>
                        </ins>
                        (обычно это 2 нити)
                    </div>
                </li>
                <li>
                    <div>
                        <ins>Прибавьте на
                            припуски: <?php echo $form->textField($model, 'additional', array('class' => 'much_t')) ?>
                            см
                        </ins>
                        (будет прибавлено с каждой стороны)
                        <?php echo $form->error($model, 'additional'); ?>
                    </div>
                </li>
                <li>
                    <div>
                        <ins>Выберите номер ткани:
                            <?php echo $form->dropDownList($model, 'canva', array(25 => 25, 27 => 27, 28 => 28, 32 => 32, 36 => 36), array('class' => "num_cal chzn", 'empty'=>'--')) ?>
                        </ins>
                        (количество нитей в одном дюйме)
                        <?php echo $form->error($model, 'canva'); ?>
                    </div>
                </li>
            </ul>
            <input type="submit" class="calc_bt" value="Рассчитать"/>
        </div>
        <?php echo $form->errorSummary($model) ?>

        <!-- .tissue_calc -->
        <div class="tissue_result" id="res" style="display: none;">
            64 x 64 <span>см</span>
        </div>
        <?php $this->endWidget(); ?>
        <!-- .tissue_result -->
    </div>
    <!-- .tissue_left -->
    <?php $model = new FabricCalculatorForm2() ?>
    <div class="tissue_right">
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'fabric-calculator-form2',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('/sewing/default/FabricCalculator'),
            'afterValidate' => "js:function(form, data, hasError) {
                                    if (!hasError)
                                        fabricCalculator.calc2();
                                    else{
                                        $('#res1').html('').hide();
                                    }
                                    return false;
                                  }",
        )));?>
        <div class="tissue_type">
            <span><ins>Для канвы</ins></span>

            <div class="style_rarr"></div>
            <!-- .style_rarr -->
        </div>
        <!-- .tissue_type -->
        <div class="tissue_calc">
            <ul>
                <li class="hide-div">
                    <ins>Введите размер схемы<br/> в стежках:</ins>
                    <div>
                        Ширина <?php echo $form->textField($model, 'width', array('class' => 'wh_t')) ?>
                        <?php echo $form->error($model, 'width'); ?>
                    </div>
                    <div>
                        Высота <?php echo $form->textField($model, 'height', array('class' => 'wh_t')) ?>
                        <?php echo $form->error($model, 'height'); ?>
                    </div>
                </li>
                <li>
                    <div>
                        <ins>Прибавьте на
                            припуски: <?php echo $form->textField($model, 'additional', array('class' => 'much_t')) ?>
                            см
                        </ins>
                        (будет прибавлено с каждой стороны)
                        <?php echo $form->error($model, 'additional'); ?>
                    </div>
                </li>
                <li>
                    <div>
                        <ins>Выберите номер ткани:
                            <?php echo $form->dropDownList($model, 'canva', array(11 => 11, 14 => 14, 16 => 16, 18 => 18, 22 => 22), array('class' => "num_cal chzn", 'empty'=>'--')) ?>
                        </ins>
                        (количество нитей в одном дюйме)
                        <?php echo $form->error($model, 'canva'); ?>
                    </div>
                </li>
            </ul>
            <input type="submit" class="calc_bt" value="Рассчитать"/>
        </div>

        <?php echo $form->errorSummary($model) ?>

        <!-- .tissue_calc -->
        <div class="tissue_result" id="res1" style="display: none;">
            64 x 64 <span>см</span>
        </div>
        <!-- .tissue_result -->
        <?php $this->endWidget(); ?>
    </div>
    <!-- .tissue_right -->
</div><!-- .embroidery_service --><br><br>

<div class="wysiwyg-content">
    <h1>Калькулятор ткани</h1>

    <p>На том участке ткани, где расположился крестик начинающей мастерицы, поместится 16 крестиков опытной
        вышивальщицы. Мелкие крестики позволяют чётче прорисовать детали и сделать работу более высокого уровня.
        Поэтому, если брать одну и ту же схему для вышивания, то размер готовой работы может отличаться значительно –
        всё зависит от величины крестиков или стежков.</p>

    <div class="brushed">
        <p>Хотите узнать прямо сейчас, какой кусок ткани или канвы вам понадобится для давно присмотренной схемы?
            Воспользуйтесь услугами нашего сервиса! Введите нужные данные в специальные формы.</p>

        <p>Для ткани:</p>
        <ul>
            <li>количество стежков по ширине и высоте,</li>
            <li>количество пересечений нитей у одного крестика,</li>
            <li>припуски у работы (если нет – ставим 0, если да – проставляем в сантиметрах),</li>
            <li>номер ткани (если не знаете – посчитайте количество нитей в 2,5 сантиметрах).</li>
        </ul>

        <p>Для канвы:</p>
        <ul>
            <li>количество крестиков по ширине и высоте,</li>
            <li>припуски у работы (если нет – ставим 0, если да – проставляем в сантиметрах),</li>
            <li>номер канвы (если не знаете – посчитайте количество клеточек в 2,5 сантиметрах).</li>
        </ul>

        <p>Через секунду вы получите размеры будущей работы в сантиметрах, что позволит подобрать подходящий материал и
            заранее присмотреть место, где эта вышивка будет радовать вас, вашу семью и гостей.</p>
    </div>
</div>