<div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo-post"<?php if ($model->isNewRecord && empty($club_id)) echo ' style="display:none;"' ?>>
    <?php if (empty($club_id)){
        $action = $model->isNewRecord ? array('save') : array('save', 'id' => $model->id);
    }else
        $action = $model->isNewRecord ? array('/community/default/save') : array('/community/default/save', 'id' => $model->id);

    $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
        'id' => 'blog-form',
        'action' => $action,
        'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnType' => true,
                'validationDelay' => 400,
            ),
        )); ?>

    <?=$form->hiddenField($model, 'type_id')?>

    <?php if ($model->isNewRecord): ?>
        <div class="b-settings-blue_tale"></div>
    <?php endif; ?>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
            </div>
            <?=$form->label($model, 'title', array('class' => 'b-settings-blue_label')) ?>
            <div class="w-400 float-l">
                <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Придумайте заголовок', 'data-bind' => 'value: title, valueUpdate: \'keydown\'')) ?>
                <?=$form->error($model, 'title') ?>
            </div>
        </div>
        <?php $this->renderPartial('form/_rubric', array('model' => $model, 'form' => $form, 'club_id' => $club_id)); ?>
    </div>

    <?php $this->renderPartial('application.views.upload_image_popup'); ?>
    <div class="clearfix textalign-r" style="display: none;">
        <?=$form->hiddenField($slaveModel, 'photos') ?>
        <?=$form->error($slaveModel, 'photos') ?>
    </div>

    <div class="b-settings-blue_row clearfix">
        <?=$form->textArea($slaveModel, 'text', array('class' => 'b-settings-blue_textarea itx-simple', 'placeholder'=>"Ваш текст к фотопосту", 'cols'=>80, 'rows'=>5)) ?>
    </div>

    <?php if (!empty($club_id) && Yii::app()->user->checkAccess('editor')): ?>
        <div class="clearfix">
            <div class="row-title"><?= $form->label($model, 'by_happy_giraffe'); ?>:</div>
            <div class="row-elements">
                <?= $form->checkBox($model, 'by_happy_giraffe'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="clearfix textalign-r">
        <?=$form->errorSummary(array($model, $slaveModel)) ?>
    </div>
    <div class=" clearfix">
        <button class="btn-blue btn-h46 float-r" data-bind="click: add, css: { 'btn-inactive': upload().photos().length < 3}"><?=$model->isNewRecord ? 'Добавить' : 'Сохранить'?></button>
        <a href="" class="btn-gray-light btn-h46 float-r margin-r15" onclick="$.fancybox.close();return false;">Отменить</a>

        <?php if (empty($club_id)):?>
            <div class="float-l">
                <div class="privacy-select clearfix">
                    <?=$form->hiddenField($model, 'privacy', array('data-bind' => 'value: selectedPrivacyOption().value()')) ?>
                    <div class="privacy-select_hold clearfix">
                        <div class="privacy-select_tx">Для кого:</div>
                        <div class="privacy-select_drop-hold">
                            <a class="privacy-select_a"
                               data-bind="click: $root.toggleDropdown, with: selectedPrivacyOption()">
                                <span class="ico-users active" data-bind="css: 'ico-users__' + cssClass()"></span>
                                <span class="privacy-select_a-tx" data-bind="html: title"></span>
                            </a>
                        </div>
                        <div class="privacy-select_drop" data-bind="css: { 'display-b' : showDropdown}">
                            <!-- ko foreach: privacyOptions -->
                            <div class="privacy-select_i">
                                <a class="privacy-select_a" data-bind="click: select">
                                    <span class="ico-users" data-bind="css: 'ico-users__' + cssClass()"></span>
                                    <span class="privacy-select_a-tx" data-bind="html: title"></span>
                                </a>
                            </div>
                            <!-- /ko -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

    <?php $this->endWidget(); ?>

</div>

<?php
/**
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;

$js = <<<JS
    var PhotoPostViewModel = function (data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
        self.upload = ko.observable(new UploadPhotos(data.photos, true, '#popup-user-add-photo-post'));

        self.add = function () {
            $('#CommunityPhotoPost_photos').val(self.upload().getPhotoIds());
            $('#blog-form').submit();
        }
    };
JS;

$js .= "ko.applyBindings(new PhotoPostViewModel(" . CJSON::encode($json) . "), document.getElementById('popup-user-add-photo-post'));";

if ($cs->useAMD) {
    $cs->registerAMD('add-video', array('ko' => 'knockout', 'UploadPhotos' => 'uploadPhotos', 'ko_post' => 'ko_post'), $js);
} else {
    $cs->registerScript('add-video', $js, ClientScript::POS_READY);
}
?>