<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $service Service
 */
$year = date('Y');
$model = new ChinaCalendarForm();

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/china.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCss('china-baby', '.child_sex_china_banner div.row{display: inline;}
.child_sex_china_banner .errorMessage{display: none !important;}');

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'china-calendar-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => '',
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                else{
                                    $('#china-calendar-result').hide();
                                    $('.wh_wait').hide();
                                }
                                return false;
                              }",
    ))); ?>
<div class="child_sex_china_banner">
    <div class="mam_bd">
        <span class="title_pt_bn">Месяц и год рождения матери:</span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'mother_m'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'mother_y', HDate::Range($year - 46, $year - 18), array('id' => 'ChinaCalendarForm_mother_y', 'class' => 'chzn yr_cal', 'empty' => 'год')); ?>
                    <?php echo $form->error($model, 'mother_y'); ?>
                </div>
            </li>
        </ul>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>Месяц и год зачатия ребенка:</ins></span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'baby_m', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'baby_m'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'baby_y', HDate::Range($year - 1, $year), array('class' => 'chzn yr_cal', 'empty' => 'год')); ?>
                    <?php echo $form->error($model, 'baby_y'); ?>
                </div>
            </li>
        </ul>
    </div>
    <!-- .child_bd -->
    <?php echo $form->hiddenField($model, 'review_year', array('id' => 'china_review_year')) ?>
    <input type="submit" class="btn-corncolor btn-big" value="Рассчитать"/>

</div><!-- .child_sex_china_banner -->
<div class="clear"></div>

<?php echo $form->errorSummary($model) ?>
<?php $this->endWidget(); ?>

<div id="china-calendar-result">

</div>
<div class="clear"></div>

<div class="wh_wait wh_daughter" style="display: none;">
    <div class="img-box">
        <img src="/images/baby_girl.jpg">
    </div>
    <div class="text">
        <span class="title_wh_wait">Поздравляем! У вас будет девочка!</span>

        <p>Об этом говорит древнекитайская таблица, точность результатов которой составляет 60%. Конечно, надо
            понимать,
            что это не 100%-я гарантия рождения девочки.</p>
    </div>
</div>
<div class="wh_wait wh_son" style="display: none;">
    <div class="img-box">
        <img src="/images/baby_boy.jpg">
    </div>
    <div class="text">
        <span class="title_wh_wait">Поздравляем! У вас будет мальчик!</span>

        <p>Так получается, исходя из данных древнекитайской таблицы. Её точность составляет 60%, она не даёт гарантии
            рождения мальчика, но почему бы и не попробовать?</p>
    </div>
</div>

<?php $this->widget('application.widgets.serviceSocial.serviceSocialWidget', array(
    'service' => $service,
    'image' => '/images/services/baby/sex-child/china_bann.jpg',
    'description' => 'По мнению китайских мудрецов, узнать пол будущего малыша можно по возрасту женщины на момент зачатия.'
)); ?>

<br><br>
<div class="wysiwyg-content">
    <h1>Китайский метод определения пола ребенка</h1>

    <p>По мнению китайских мудрецов, узнать пол будущего малыша можно по возрасту женщины на момент зачатия. Исходя из
        того, что в Китае семья может иметь только одного малыша и малыш, соответственно, должен быть желаемого пола,
        эффективность данного метода должна быть достаточно высокой. Именно поэтому все большее число пар планирует
        ребенка по китайскому методу.</p>

    <p>Например, мама 23 лет, которая забеременела зимой или осенью, вероятнее всего родит мальчика, а если зачатие
        случилось весной – то девочку. У мамы 22 лет ситуация кардинально меняется с точностью до наоборот.</p>

    <p>Древнекитайскую таблицу по планированию пола будущего малыша без проблем можно найти, но, скажем честно, она
        довольно-таки запутанная.</p>

    <p>Однако мы разобрались во всех нюансах этого метода, а наши программисты заложили эти знания в автоматическую
        систему. Так что китайским методом вы сможете легко воспользоваться – просто ответьте на вопросы системы.</p>

    <p>Исходя из того, что данный метод, по мнению современных медиков, «работает» на 60%, можно попробовать – а вдруг
        получится!</p>
</div>