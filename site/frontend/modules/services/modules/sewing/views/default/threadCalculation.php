<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/threadCalculation.js', CClientScript::POS_HEAD);
$this->meta_description = 'Для того чтобы сотворить прекрасную вышивку, нужны хорошая мастерица, удобные пяльцы, качественная канва, нужная игла и правильный расчет ниток. Делайте расчет ниток при помощи нашего сервиса и покупайте их столько, сколько нужно';

$model = new ThreadCalculationForm();
?><div class="embroidery_service">
    <img src="/images/service_much_thread.jpg" alt="" title=""/>
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'threads-calculator-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('threadCalculation'),
        'afterValidate' => "js:function(form, data, hasError) {
                                    if (!hasError)
                                        StartCalc();
                                    else{
                                        $('#result').html('');
                                    }
                                    return false;
                                  }",
    )));?>
    <div class="list_thread">
        <ul>
            <li>
                <div>
                    <ins>Количество крестиков:</ins>
								<span class="title_h">
									<?php echo $form->textField($model, 'cross_count') ?>
                                    <?php echo $form->error($model, 'cross_count'); ?>
								</span>
                </div>
            </li>
            <li>
                <div>
                    <ins>Номер канвы Aida:</ins>
								<span class="title_h">
                                    <?php echo $form->dropDownList($model, 'canva', array(11 => 11, 14 => 14, 16 => 16, 18 => 18, 22 => 22), array('class' => "chzn yr_cal", 'empty' => '-')) ?>
                                    <?php echo $form->error($model, 'canva'); ?>
								</span>
                </div>
            </li>
            <li>
                <div>
                <ins>Сложений нити</ins>
								<span class="title_h">
                                    <?php echo $form->dropDownList($model, 'threads_num', HDate::Range(1,6), array('class' => "chzn yr_cal", 'empty' => '-')) ?>
                                    <?php echo $form->error($model, 'threads_num'); ?>
								</span>
                </div>
            </li>
            <li>
                <input type="submit" class="calc_bt" value="Рассчитать"/>
            </li>
        </ul>
    </div>
    <div id="result">

    </div>

    <?php echo $form->errorSummary($model) ?>

    <?php $this->endWidget(); ?>
</div><!-- .embroidery_service -->

<div class="seo-text">
    <h1 class="summary-title">Расчёт ниток для вышивания</h1>

    <p>Очень часто бывает так: нравится схема для вышивания, но нити к ней в комплекте не идут. Рядом есть, конечно,
        магазин, в котором можно их купить, только вот – сколько?</p>

    <p>Как посчитать, сколько ниток каждого цвета потребуется для работы?</p>

    <div class="brushed">
        <h3>Именно для этого создан наш сервис</h3>

        <p>Всё просто! Необходимо предварительно посчитать приблизительное количество крестиков каждого цвета, которые
            нужно будет вышить. Затем для каждого цвета отдельно вводим данные в специальную форму:</p>
        <ul>
            <li>количество крестиков,</li>
            <li>номер канвы Aida,</li>
            <li>сколько сложений будет иметь нить.</li>
        </ul>
        <p>Через секунду вы получите результат в метрах и мотках.</p>
    </div>
    <p>Конечно, посчитать количество крестиков очень точно – сложно, однако от этого зависит верность расчёта. Если есть
        сомнения в правильности подсчёта, увеличьте количество крестиков.</p>

    <p>После того, как вы посчитаете необходимый метраж нитей – проверьте себя.</p>
    <ul style="list-style-type: decimal;">
        <li>Определите итоговое количество крестиков в схеме, умножив их количество по горизонтали на количество по
            вертикали, введите эти данные в форму и запишите результат. Назовём его «Результат общий».
        </li>
        <li>Теперь суммируйте метраж каждого цвета – полученный результат назовём «Результат суммы».</li>
        <li>Ваши расчёты верны, если Результат суммы больше чем Результат общий на 25 – 30%.</li>
    </ul>
    <p><b>Важно:</b></p>
    <ul>
        <li>Если вы вышиваете недавно, то расходуете больше нитей.</li>
        <li>Если разброс цветов на картинке большой – нитей тратится больше.</li>
        <li>Если вы вышиваете нитью, сложенной в три и больше раз – расход нити увеличивается дополнительно.</li>
    </ul>
    <p>В каждом из этих случаев общий результат нужно увеличить на 20%.</p>

    <p><b>Теперь можно и в магазин!</b></p>
</div>