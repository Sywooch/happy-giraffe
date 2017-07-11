<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
if (empty($club_id)){
    $action = $model->isNewRecord ? array('/blog/default/save') : array('/blog/default/save', 'id' => $model->id);
}else
    $action = $model->isNewRecord ? array('/community/default/save') : array('/community/default/save', 'id' => $model->id);

$form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id' => 'blog-form',
    'action' => $action,
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnType' => true,
        'validationDelay' => 400,
    ),
));

?>

<?=$form->hiddenField($model, 'type_id')?>
<input type="hidden" name="formKey" value="<?= \site\frontend\components\FormDepartmentModelsControl::getInstance()->createNewFormKey() ?>">

<div id="add-article">
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="float-r">
                <select name="<?=CHtml::activeName($model, 'forum_id')?>" id="<?=CHtml::activeId($model, 'forum_id')?>" data-bind="options: rubricsList,
                    value: selectedRubric,
                    optionsText: function(rubric) {
                        return rubric.title;
                    },
                    optionsValue: function(rubric) {
                        return rubric.id;
                    },
                    select2: {
                        allowClear: true,
                        minimumResultsForSearch: -1,
                        dropdownAutoWidth: true,
                        containerCssClass: '',
                        dropdownCssClass: 'select-dropdown'
                    }" data-placeholder="Выберите подфорум">
                </select>
                <?=$form->error($model, 'forum_id')?>
            </div>
        </div>
    </div>
    <div class="add-question__panel">
        <div class="b-popup-form__panel">
            <div class="input-field">
                <?php echo $form->textField($model, 'title', ['class' => 'material-theme', 'id' => 'theme']); ?>
                <label for="theme">Заголовок записи</label>
            </div>
            <?php echo $form->error($model, 'title'); ?>
        </div>
    </div>
    <div class="add-question__panel">
        <div class="b-redactor">
            <div class="b-redactor__head-toolbar b-redactor__head-toolbar--grey js-stiky-redactor">
                <div id="redactor-post-toolbar2"></div>
            </div>
            <div class="b-redactor__action b-margin--bottom_10">
                    <?php $slaveModel->text = $slaveModel->forEdit->text; ?>

                    <?php echo $form->textArea($slaveModel, 'text', ['class' => 'b-redactor__textarea', 'placeholder' => 'Введите текст']); ?>
            </div>
            <div class="b-redactor__footer b-redactor--theme-right">
                <div class="b-redactor-footer__item">
                    <button class="btn btn--default btn--lg">Опубликовать</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
/**
 * @var ClientScript $cs
 */
$cs = \Yii::app()->clientScript;

$wysiwyg_js = <<<JS
    $('.b-redactor__textarea').redactorHG({
        toolbarExternal: '#redactor-post-toolbar2',
        plugins: ['text','toolbarVerticalFixed'],
        minHeight: 266,
        autoresize: true,
        buttons: ['unorderedlist', 'orderedlist', 'link_add', 'image', 'video', 'smile']
    });
JS;

$js = <<<JS
    var BlogFormPostViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
    };
JS;
var_dump($json);
$js .= "ko.applyBindings(new BlogFormPostViewModel(" . CJSON::encode($json) . "), document.getElementById('add-article'));";


$cs->registerAMD('wysiwyg-old', array('wysiwyg_old' => 'wysiwyg_old'), $wysiwyg_js);
$cs->registerAMD('add-post', array('ko' => 'knockout', 'ko_post' => 'ko_post'), $js);


?>
