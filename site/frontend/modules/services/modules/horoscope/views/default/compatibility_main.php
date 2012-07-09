<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */

Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

?><div id="horoscope">

<div class="horoscope-compatibility clearfix">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'placenta-thickness-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => $this->createUrl('default/calculate'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('calculate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Horoscope.calc();
                                return false;
                              }",
    )));?>


    <div class="sign">
        <div class="img"><img src="/images/widget/horoscope/big/4.png"></div>
        <?=$form->dropDownList($model, 'zodiac1', Horoscope::model()->zodiac_list, array('class'=>'chzn')) ?>
    </div>
    <div class="plus"></div>
    <div class="sign">
        <div class="img"><img src="/images/widget/horoscope/big/7.png"></div>
        <?=$form->dropDownList($model, 'zodiac2', Horoscope::model()->zodiac_list, array('class'=>'chzn')) ?>
    </div>
    <div class="equal"></div>
    <div class="button">
        <a href="javascript:;" onclick="this.form.submit();">Узнать!</a>
    </div>
    <?php $this->endWidget(); ?>
</div>

<div class="wysiwyg-content">

    <h2>Гороскоп совместимости</h2>

    <p>Эффект взаимного притяжения очень хорошо просматривается на примере этой пары. Самое большое удовольствие для них – духовное общение и обмен мнениями. Оба знака очень интеллектуальны и интересуются всем на свете. Это шумные создания, и одно из любимейших их занятий – подискутировать на интересную тему. Оба не переносят малейшее ограничение их свободы. А вот в постели ничего яркого они продемонстрировать не смогут, так как оба будут ждать инициативы от партнера.</p>
    <p>Глядя на них со стороны, не сразу поймешь, какие отношения их связывают: то ли это любовники, то ли хорошие друзья, а может, это старые враги, которые лишь скрывают свою неприязнь? Они и сами порой не уверены до конца, кем приходятся друг другу.</p>

</div>

<div class="clearfix">

    <div class="horoscope-compatibility-list">
        <ul>
            <?php foreach (Horoscope::model()->zodiac_list as $key => $zodiac): ?>
                <li>
                    <div class="img">
                        <img src="/images/widget/horoscope/smaller/<?=$key ?>.png">
                        <div class="date"><span><?=$zodiac ?></span><?=Horoscope::model()->someZodiacDates($key) ?></div>
                    </div>
                    <ul>
                        <?php foreach (Horoscope::model()->zodiac_list as $key2 => $zodiac2): ?>
                            <li><a href="<?=$model->getUrl($key, $key2) ?>"><?=$zodiac ?> - <?=$zodiac2 ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>

</div>