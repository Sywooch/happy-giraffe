<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/yarnCalculator.js', CClientScript::POS_HEAD);
$this->meta_description = 'Наш новый сервис позволяет рассчитать, сколько нужно пряжи для вязания конкретной вещи. Введите простые данные в специальную форму. Минута – и нет мучительных раздумий у витрины магазина!';

$model = new YarnCalcForm;
?><div class="embroidery_service">
    <img src="/images/service_much_yarn.jpg" alt="" title=""/>
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'yarn-calculator-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('yarnCalculator'),
        'afterValidate' => "js:function(form, data, hasError) {
                                    if (!hasError)
                                        StartCalc();
                                    else{
                                        $('#result').html('');
                                    }
                                    return false;
                                  }",
    )));?>
    <div class="list_yarn">
        <ul>
            <li>
                <div class="row">
                <ins>Что вяжем?</ins>
								<span class="title_h">
                                    <?php echo $form->dropDownList($model, 'project', CHtml::listData(YarnProjects::model()->cache(60)->findAll(), 'id', 'name'), array('class' => 'mn_cal chzn', 'empty' => 'Выберите проект')) ?>
                                    <?php echo $form->error($model, 'project'); ?>
								</span>
                </div>
            </li>
            <li>
                <div class="row">
                <ins>Размер</ins>
								<span class="title_h">
                                    <?php echo $form->dropDownList($model, 'size', array(), array('class' => "num_cal chzn", 'empty' => 'Выберите размер')) ?>
                                    <?php echo $form->error($model, 'size'); ?>
                                    <br>
								</span>
                </div>
            </li>
            <li>
                <div class="row">
                <ins>Количество петель</ins>
								<span class="title_h">
                                    <?php echo $form->dropDownList($model, 'gauge', array(), array('class' => "yr_cal chzn", 'empty' => 'Выберите количество петель')) ?>
                                    <?php echo $form->error($model, 'gauge'); ?>
								</span>
                </div>
            </li>
            <li>
                <input type="submit" class="calc_bt" value="Рассчитать"/>
            </li>
        </ul>
    </div>
    <!-- .list_yarn -->
    <div id="result">

    </div>

    <?php echo $form->errorSummary($model) ?>

    <?php $this->endWidget(); ?>
</div><!-- .embroidery_service -->
<div class="seo-text">
    <h1 class="summary-title">Сколько пряжи для вязания нужно?</h1>

    <p>Вы хотите связать жилет для мужа, пуловер для себя или носочки для будущего малыша, но не знаете, на что хватит
        пряжи дома, а на что – лучше купить в магазине?</p>

    <div class="brushed">
        <h3>Воспользуйтесь нашим сервисом!</h3>

        <p>Это очень просто. Для начала вам нужно связать образец в виде квадрата со сторонами 10 сантиметров. Потом –
            подсчитать количество петель, уместившихся в одном ряду.</p>

        <p>Вводим в специальную форму:</p>
        <ul>
            <li>Название изделия,</li>
            <li>Его размер,</li>
            <li>Количество петель, уместившихся в одном ряду образца.</li>
        </ul>
        <p>Через секунду вы получите результат, сколько метров пряжи вам потребуется.</p>
    </div>

    <p><b>Важно:</b></p>
    <ul>
        <li>При вывязывании ажурных узоров с крупными отверстиями пряжи может понадобиться меньше, но лучше взять
            рассчитанное количество.
        </li>
        <li>Если вы планируете вывязывать объёмный узор – косы, шишки, узорную резинку, дополнительные или накладные
            элементы изделия – пряжи может понадобиться значительно больше. В этом случае количество пряжи лучше
            увеличить на 10 – 20%.
        </li>
    </ul>
    <p><b>Удачного вам вязания!</b></p>
</div>