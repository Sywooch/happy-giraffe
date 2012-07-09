<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */

Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript
    ->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD)
    ->registerScriptFile(Yii::app()->baseUrl . '/javascripts/history.js');

?><div id="horoscope">

<div class="horoscope-compatibility clearfix">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'placenta-thickness-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => '#',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('validate'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Horoscope.calc();
                                return false;
                              }",
    )));?>


    <div class="sign">
        <div class="img"><img src="<?=Horoscope::getZodiacPhoto($model->zodiac1) ?>"></div>
        <?=$form->dropDownList($model, 'zodiac1', Horoscope::model()->zodiac_list, array(
        'class'=>'chzn',
        'onchange'=>'Horoscope.ZodiacChange(this)',
        'empty'=>'--',
    )) ?>
        <?=$form->error($model, 'zodiac1') ?>
    </div>
    <div class="plus"></div>
    <div class="sign">
        <div class="img"><img src="<?=Horoscope::getZodiacPhoto($model->zodiac2) ?>"></div>
        <?=$form->dropDownList($model, 'zodiac2', Horoscope::model()->zodiac_list, array(
        'class'=>'chzn',
        'onchange'=>'Horoscope.ZodiacChange(this)',
        'empty'=>'--',
    )) ?>
        <?=$form->error($model, 'zodiac2') ?>
    </div>
    <div class="equal"></div>
    <div class="button">
        <a href="javascript:;" onclick="$(this).parents('form').submit();">Узнать!</a>
    </div>
    <?php $this->endWidget(); ?>
</div>

<div class="wysiwyg-content">

    <h2>Гороскоп совместимости</h2>

    <div id="result">
        <?php if (!empty($model->text)) echo Str::strToParagraph($model->text); ?>
    </div>
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