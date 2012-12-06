<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
$model = new JapanCalendarForm;

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/japan.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCss('japan-baby', '.child_sex_japan_banner div.row {display: inline;}
    .child_sex_japan_banner .errorMessage {display: none !important;}');

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'japan-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => '',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('/babySex/japanCalc'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                return false;
                              }",
    ))); ?>
<div class="child_sex_japan_banner">
    <div class="dad_bd">
        <span class="title_pt_bn">Месяц рождения отца:</span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'father_m', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'father_m'); ?>
                </div>
            </li>
        </ul>
    </div>
    <!-- .dad_bd -->
    <div class="mam_bd">
        <span class="title_pt_bn">Месяц рождения матери:</span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'mother_m'); ?>
                </div>
            </li>
        </ul>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>День и месяц зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'baby_d', HDate::Days(), array('class' => 'chzn num_cal', 'empty' => 'день')); ?>
                    <?php echo $form->error($model, 'baby_d'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'baby_m'); ?>
                </div>
            </li>
        </ul>
        <?php echo $form->error($model, 'baby_d'); ?>
        <?php echo $form->error($model, 'baby_m'); ?>
    </div>
    <!-- .child_bd -->
    <?php echo $form->hiddenField($model, 'review_month', array('id' => 'japan_review_month')) ?>
    <input type="submit" class="calc_bt" value="Рассчитать"/>
</div><!-- .child_sex_banner -->
<?php echo $form->errorSummary($model) ?>
<?php $this->endWidget(); ?>

<div id="japan-result">

</div>

<?php $this->widget('application.widgets.serviceSocial.serviceSocialWidget', array(
    'service' => $service,
    'image' => '/images/sex_child_japan_bann.jpg',
    'description' => 'Все жители Японии, а в особенности семейные пары, очень трепетно относятся к детям. Иметь продолжателей своего рода – основная обязанность каждой семьи.'
)); ?>

<br><br>
<div class="wysiwyg-content">
    <h1>Японский метод планирования пола ребенка</h1>
    <p>Все жители Японии, а в особенности семейные пары, очень трепетно относятся к детям. Иметь продолжателей своего
        рода – основная обязанность каждой семьи. Желательно, чтобы в семье был мальчик, – для отцов семейства это очень
        важно. Если в семье рождаются одни девочки, мужчина может прибегнуть к связи «на стороне» или к усыновлению
        желаемого наследника – такие в этой стране правила. Наличие детей определяет статус и уважение японцев в
        обществе. Поэтому семейные пары часто прибегают к планированию будущего пола малыша с помощью своего исконного
        традиционного метода.</p>

    <p>Планирование пола будущего малыша при японском методе рассчитывается, исходя из данных родителей. Это таблица,
        содержащая месяцы рождения отца и матери и месяцы зачатия. Если папа и мама, к примеру, родились в ноябре, то
        девочку они смогут зачать в июле, а мальчика – в октябре. Эффективность данного метода составляет около 55% и не
        является гарантом желаемого результата. Но, как говорится, «попытка – не пытка». Вы можете воспользоваться этим
        методом, считать самим не придется: вы закладываете данные в систему, она их обрабатывает и сообщает вам о
        вероятности рождения мальчика или девочки.</p>
</div>