<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model LinkForm
 */
?>
<div id="wysiwygAddLink" class="popup">

    <a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

    <div class="title">Вставить ссылку</div>

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'link-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => '#',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('/ajax/link'),
        'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    epic_func_mylink();
                                return false;
                              }",
    )));?>

    <div class="row">
        <label>Адрес ссылки</label><br>
        <?=$form->textField($model, 'url', array('class' => 'link-address', 'placeholder' => 'Вставьте ссылку')) ?>
        <?=$form->error($model, 'url') ?>
    </div>

    <div class="row">
        <label>Название ссылки</label><br>
        <?=$form->textField($model, 'title', array('class' => 'link-name', 'placeholder' => 'Введите название')) ?>
        <?=$form->error($model, 'title') ?>
    </div>
    <div class="bottom">
        <a href="javascript:;" class="btn btn-green-medium" id="add-mylink" onclick="$(this).parents('form').submit();"><span><span>Ok</span></span></a>
    </div>

    <?php $this->endWidget(); ?>

</div>