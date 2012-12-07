<?php
/* @var $this HController
 * @var $form CActiveForm
 */
$year = date('Y');
$model = new BloodRefreshForm();

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/blood_refresh.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCss('blood_refresh', '.lists_td .errorMessage {display: none !important;}');

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'blood-refresh-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => '',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('/babySex/BloodUpdate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    StartCalc();
                                return false;
                              }",
    ))); ?>
<div class="child_sex_banner">
    <div class="dad_bd">
        <span class="title_pt_bn">День рождения отца:</span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'father_d', HDate::Days(), array('class' => 'chzn num_cal', 'empty' => 'день')); ?>
                    <?php echo $form->error($model, 'father_d'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'father_m', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'father_m'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'father_y', HDate::Range($year - 65, $year - 15), array('class' => 'chzn yr_cal', 'empty' => 'год')); ?>
                    <?php echo $form->error($model, 'father_y'); ?>
                </div>
            </li>
        </ul>
        <div>
            <?php echo $form->hiddenField($model, 'father_born_date') ?>
            <?php echo $form->error($model, 'father_born_date'); ?>
        </div>
    </div>
    <!-- .dad_bd -->
    <div class="mam_bd">
        <span class="title_pt_bn">День рождения матери:</span>
        <ul class="lists_td">
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'mother_d', HDate::Days(), array('class' => 'chzn num_cal', 'empty' => 'день')); ?>
                    <?php echo $form->error($model, 'mother_d'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'mother_m', HDate::ruMonths(), array('class' => 'chzn mn_cal', 'empty' => 'месяц')); ?>
                    <?php echo $form->error($model, 'mother_m'); ?>
                </div>
            </li>
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'mother_y', HDate::Range($year - 65, $year - 15), array('class' => 'chzn yr_cal', 'empty' => 'год')); ?>
                    <?php echo $form->error($model, 'mother_y'); ?>
                </div>
            </li>
        </ul>
        <div>
            <?php echo $form->hiddenField($model, 'mother_born_date') ?>
            <?php echo $form->error($model, 'mother_born_date'); ?>
        </div>
    </div>
    <!-- .mam_bd -->
    <div class="child_bd">
        <span class="title_pt_bn"><ins>День зачатия ребенка:</ins></span>
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
            <li>
                <div class="row">
                    <?php echo $form->dropDownList($model, 'baby_y', HDate::Range($year-1, $year), array('class' => 'chzn yr_cal', 'empty' => 'год')); ?>
                    <?php echo $form->error($model, 'baby_y'); ?>
                </div>
            </li>
        </ul>
        <div>
            <?php echo $form->hiddenField($model, 'baby_born_date') ?>
            <?php echo $form->error($model, 'baby_born_date'); ?>
        </div>
    </div>
    <!-- .child_bd -->
    <?php echo $form->hiddenField($model, 'review_month', array('id' => 'blood_refr_review_month')) ?>
    <?php echo $form->hiddenField($model, 'review_year', array('id' => 'blood_refr_review_year')) ?>
    <input type="submit" class="calc_bt" value="Рассчитать"/>
</div><!-- .child_sex_banner -->
<?php $this->endWidget(); ?>
<div id="blood-update-result">

</div>


<?php $this->widget('application.widgets.serviceSocial.serviceSocialWidget', array(
    'service' => $service,
    'image' => '/images/services/baby/sex-child/parrents_bann.jpg',
    'description' => 'В основе данного метода лежит цикличность обновления крови женщины и мужчины в зависимости от их возраста...'
)); ?>


<br><br>
<div class="wysiwyg-content">
    <h1>Пол ребенка по дате рождения родителей</h1>
    <p>В основе данного метода лежит цикличность обновления крови женщины и мужчины в зависимости от их возраста. Эти
        циклы представляют собой определенные временные периоды, которые начинаются со дня рождения. Если на момент
        зачатия «моложе» была кровь женщины – значит, родится девочка, если кровь мужчины – мальчик.</p>

    <p>По правде говоря, эффективность данного метода недостаточно высока. Так что, если результат не оправдал ваших
        ожиданий – не расстраивайтесь. Главное – чтобы это был здоровый малыш, а поэкспериментировать вы сможете еще –
        со следующим ребенком.</p>
</div>