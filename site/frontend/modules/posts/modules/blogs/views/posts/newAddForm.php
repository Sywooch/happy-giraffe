<?php

$cs = Yii::app()->clientScript;

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

$js .= "ko.applyBindings(new BlogFormPostViewModel(" . CJSON::encode($json) . "), document.getElementById('popup-user-add-blog'));";

if ($cs->useAMD)
{
    $cs->registerAMD('wysiwyg-old', array('wysiwyg_old' => 'wysiwyg_old'), $wysiwyg_js);
    $cs->registerAMD('add-post', array('ko' => 'knockout', 'ko_post' => 'ko_post'), $js);
}
else
{
    $cs->registerScript('wysiwyg-old', $wysiwyg_js, ClientScript::POS_READY);
    $cs->registerScript('add-post', $js, ClientScript::POS_READY);
}

?>

<?php

$action = $model->isNewRecord ? array('/blog/default/save') : array('/blog/default/save', 'id' => $model->id);

$form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id'     => 'blog-form',
    'action' => $action,
    'enableAjaxValidation'   => true,
    'enableClientValidation' => true,
    'clientOptions' => [
        'validateOnSubmit' => true,
        'validateOnType'   => true,
        'validationDelay'  => 400,
    ],
));

echo $form->hiddenField($model, 'type_id');

?>

<script>

$('.wysiwyg-redactor-v').promise().done(function()
{
    setTimeout(function()
    {
        $('#popup-user-add-blog').css('visibility', 'visible');
    }, 500);
});

</script>

<input type="hidden" name="formKey" value="<?php echo \site\frontend\components\FormDepartmentModelsControl::getInstance()->createNewFormKey(); ?>">

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

<?php $this->endWidget(); ?>
