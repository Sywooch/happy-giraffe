<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */

$form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id' => 'blog-form',
    'action' => $model->isNewRecord ? array('save') : array('save', 'id' => $model->id),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnType' => true,
        'validationDelay' => 400,
    ),
)); ?>

<?php if (isset($_GET['redirect'])) echo CHtml::hiddenField('redirect', $_GET['redirect']) ?>
<?=$form->hiddenField($model, 'type_id')?>

<div id="popup-user-add-status" class="b-settings-blue b-settings-blue__status">

    <?php if ($model->isNewRecord): ?>
        <div class="b-settings-blue_tale"></div>
    <?php endif; ?>

    <div class="b-status-add clearfix">
        <div class="float-l">
            <?php $this->widget('Avatar', array('user' => $this->user)); ?>
        </div>
        <div class="b-status-add_col">
            <div class="b-status-add_hold">
                <div class="clearfix">
                    <div class="float-r font-small color-gray" data-bind="length: { attribute : text, maxLength : 250 }"></div>
                </div>
                <?=$form->textArea($slaveModel, 'text', array('cols' => 60, 'rows' => 3, 'class' => 'b-status-add_textarea', 'data-bind' => 'value: text, valueUpdate: \'keyup\''))?>
                <?=$form->error($slaveModel, 'text')?>
            </div>
            <div class="margin-b10 clearfix">
                <div class="b-user-mood">
                    <?=$form->hiddenField($slaveModel, 'mood_id', array('data-bind' => 'value: selectedMoodId'))?>
                    <div class="b-user-mood_img">
                        <img data-bind="attr: { src : selectedMoodImagePath }">
                        <div class="b-moods-list" data-bind="visible: choiceVisible"">
                            <ul class="b-moods-list_ul">
                                <!-- ko foreach: moods -->
                                <li class="b-moods-list_li">
                                    <a class="b-moods-list_a" data-bind="click: select">
                                        <img class="b-moods-list_img" data-bind="attr: { src : imagePath }">
                                        <span class="b-moods-list_tx" data-bind="text: title"></span>
                                    </a>
                                </li>
                                <!-- /ko -->
                            </ul>
                        </div>
                    </div>
                    <div class="b-user-mood_hold">
                        <!-- ko if: selectedMoodId() === null -->
                        <a class="a-pseudo" data-bind="click: toggleChoiceVisible">Прикрепить <br> мое настроение</a>
                        <!-- /ko -->
                        <!-- ko if: selectedMoodId() !== null -->
                        <div class="b-user-mood_tx">- мое настроение</div>
                        <a class="a-pseudo font-small margin-l10" data-bind="click: toggleChoiceVisible">Изменить</a> &nbsp;
                        <a class="a-pseudo-gray font-small" data-bind="click: removeMood">Удалить</a>
                        <!-- /ko -->
                    </div>
                </div>
            </div>

            <div class=" clearfix">
                <button class="btn-blue btn-h46 float-r"><?=$model->isNewRecord ? 'Добавить' : 'Сохранить'?></button>
                <a href="javascript:void(0)" onclick="$.fancybox.close()" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>

                <div class="float-l">
                    <div class="privacy-select clearfix">
                        <?=$form->hiddenField($model, 'privacy', array('data-bind' => 'value: selectedPrivacyOption().value()'))?>
                        <div class="privacy-select_hold clearfix">
                            <div class="privacy-select_tx">Для кого:</div>
                            <div class="privacy-select_drop-hold">
                                <a class="privacy-select_a" data-bind="click: $root.toggleDropdown, with: selectedPrivacyOption()">
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
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
/**
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;

$js = <<<JS
    var BlogFormStatusViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
        self.text = ko.observable(data.text);
        self.moods = ko.utils.arrayMap(data.moods, function(mood) {
            return new Mood(mood, self);
        });
        self.selectedMoodId = ko.observable(data.mood_id);
        self.choiceVisible = ko.observable(false);

        self.toggleChoiceVisible = function() {
            self.choiceVisible(! self.choiceVisible());
        }

        self.selectedMood = ko.computed(function() {
            return ko.utils.arrayFirst(self.moods, function(mood) {
                return mood.id == self.selectedMoodId();
            })
        });

        self.selectedMoodImagePath = ko.computed(function() {
            return self.selectedMoodId() === null ? '/images/widget/mood/0.png' : self.selectedMood().imagePath();
        });

        self.removeMood = function() {
            self.selectedMoodId(null);
        }
    };

    var Mood = function(data, parent) {
        var self = this;
        self.id = data.id;
        self.title = data.title;

        self.select = function() {
            parent.selectedMoodId(self.id);
            parent.choiceVisible(false);
        }

        self.imagePath = ko.computed(function() {
            return '/images/widget/mood/' + self.id  + '.png';
        });

    };
JS;

$js .= "ko.applyBindings(new BlogFormStatusViewModel(" . CJSON::encode($json) . "), document.getElementById('popup-user-add-status'));";

if ($cs->useAMD) {
    $cs->registerAMD('add-status', array('ko' => 'knockout', 'ko_post' => 'ko_post'), $js);
} else {
    $cs->registerScript('add-status', $js, ClientScript::POS_READY);
}
?>