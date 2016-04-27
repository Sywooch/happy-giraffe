<?php
/**
 * @var CommunityContest $contest
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'blog-form',
    'action' => $model->isNewRecord ? array('/community/default/save') : array('/community/default/save', 'id' => $model->id),
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnType' => true,
        'validationDelay' => 400,
    ),
)); ?>
<input type="hidden" name="formKey" value="<?= \site\frontend\components\FormDepartmentModelsControl::getInstance()->createNewFormKey() ?>">
<?=$form->hiddenField($model, 'type_id')?>
<?=$form->hiddenField($model, 'rubric_id')?>
<?=CHtml::hiddenField('contest_id', $contest->id)?>

<div id="popup-contest" class="popup-contest popup-contest__birth2">
    <a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">

            <div class="b-settings-blue">
                <div class="b-settings-blue_head">
                    <div class="clearfix">
                        <label for="" class="b-settings-blue_label margin-t0">
                            <img src="/images/contest/club/<?=$contest->cssClass?>/small.png" alt="">
                        </label>
                        <div class="b-settings-blue_row-tx">
                            <div class="heading-medium"><?=$contest->title?></div>
                        </div>
                    </div>
                    <div class="b-settings-blue_row clearfix">
                        <div class="clearfix margin-t-10 ">
                            <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
                        </div>
                        <label for="" class="b-settings-blue_label">Заголовок</label>
                        <div class="b-settings-blue_row-tx">
                            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-100p', 'placeholder' => 'Введите заголовок рассказа', 'data-bind' => 'value: title, valueUpdate: \'keydown\'')) ?>
                            <?=$form->error($model, 'title') ?>
                        </div>
                    </div>

                    <div class="wysiwyg-v wysiwyg-blue clearfix">
                        <label for="" class="b-settings-blue_label">Рассказ</label>
                        <?php $slaveModel->text = $slaveModel->forEdit->text ?>
                        <?=$form->textArea($slaveModel, 'text', array('class' => 'wysiwyg-redactor-v', 'placeholder' => $contest->textHint))?>
                        <?=$form->error($slaveModel, 'text')?>
                    </div>

                </div>

                <div class=" clearfix">
                    <button data-bind="css: { 'btn-inactive': rulesAccepted() === false }" class="btn-blue btn-h46 float-r"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></button>
                    <a href="javascript:void(0)" class="btn-gray-light btn-h46 float-r margin-r15" onclick="$.fancybox.close()">Отменить</a>

                    <div class="float-l margin-t15">
                        <a class="a-checkbox" data-bind="css: { active : rulesAccepted }, click: toggleRulesAccepted"></a>
                        <span class="color-gray">Я ознакомлен с</span> <a href="#popup-contest-rule" class="fancy">Правилами конкурса</a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $('.wysiwyg-redactor-v').redactorHG({
        plugins: ['toolbarVerticalFixed'],
        minHeight: 410,
        autoresize: true,
        buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile']
    });

    var BlogFormPostViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));

        self.rulesAccepted = ko.observable(false);

        self.toggleRulesAccepted = function() {
            self.rulesAccepted(! self.rulesAccepted());
        }
    }

    formVM = new BlogFormPostViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM, document.getElementById('popup-contest'));
</script>