<?php
/* @var $model HoroscopeCompatibility
 * @var $form CActiveForm
 */

if (empty($model->zodiac1) && !Yii::app()->user->isGuest){
    if (!empty(Yii::app()->user->getModel()->birthday))
        $model->zodiac1 = Horoscope::model()->getDateZodiac(Yii::app()->user->getModel()->birthday);
}
?><div class="horoscope-compatibility clearfix">

    <?php if (isset($showTitle)):?>
        <div class="block-title">Совместимость знаков</div>
    <?php endif ?>

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'placenta-thickness-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => '#',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => array('/horoscope/compatibility/validate/'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Horoscope.calc();
                                return false;
                              }",
    )));?>

    <div class="sign">
        <div class="img" onclick="Horoscope.showSelect(this)"><img src="<?=Horoscope::getZodiacPhoto($model->zodiac1) ?>"></div>
        <div class="chzn-v2-lilac"<?php if (empty($model->zodiac1)) echo ' style="display:none;"' ?>>
        <?=$form->dropDownList($model, 'zodiac1', Horoscope::model()->zodiac_list, array(
        'class'=>'chzn',
        'onchange'=>'Horoscope.ZodiacChange(this)',
        'empty'=>'&nbsp;',
    )) ?></div>
        <?=$form->error($model, 'zodiac1') ?>
    </div>
    <div class="plus"></div>
    <div class="sign">
        <div class="img" onclick="Horoscope.showSelect(this)"><img src="<?=Horoscope::getZodiacPhoto($model->zodiac2) ?>"></div>
        <div class="chzn-v2-lilac"<?php if (empty($model->zodiac2)) echo ' style="display:none;"' ?>>
        <?=$form->dropDownList($model, 'zodiac2', Horoscope::model()->zodiac_list, array(
        'class'=>'chzn',
        'onchange'=>'Horoscope.ZodiacChange(this)',
        'empty'=>'&nbsp;',
    )) ?></div>
        <?=$form->error($model, 'zodiac2') ?>
    </div>
    <div class="equal"></div>
    <a href="javascript:;" class="button btn-green btn-large" onclick="$(this).parents('form').submit();">Узнать!</a>

    <?=$form->errorSummary($model); ?>
    <?php $this->endWidget(); ?>
</div>
