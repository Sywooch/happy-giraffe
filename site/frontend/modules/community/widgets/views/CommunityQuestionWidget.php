<?php $this->beginWidget('SeoContentWidget'); ?>
<?php
/**
 * @var CommunityContent $model
 * @var CommunityQuestion $slaveModel
 * @var User $newUser
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'blog-form',
    'action' => array('/community/default/createQuestion'),
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
<?=$form->hiddenField($model, 'rubric_id')?>

<div class="b-q-specialist">
    <div class="b-q-specialist_t">
        Задать вопрос гинекологу
        <div class="b-q-specialist_t-sub">и опытным мамам прямо сейчас!</div>
    </div>
    <div class="margin-b5 clearfix">
        <div class="b-q-specialist_itx-count" data-bind="length: { attribute : title, maxLength : 100 }"></div>

    </div>
    <div class="margin-b20 clearfix">
        <?=$form->textField($model, 'title', array('class' => 'itx-simple', 'placeholder' => 'Тема вопроса', 'data-bind' => 'value: title, valueUpdate: \'keyup\''))?>
        <?=$form->error($model, 'title')?>
    </div>
    <div class="margin-b20 clearfix">
        <?=$form->textArea($slaveModel, 'text', array('class' => 'itx-simple', 'placeholder' => 'Ваш вопрос', 'cols' => '30', 'rows' => '5'))?>
        <?=$form->error($slaveModel, 'text')?>
    </div>
    <?php if ($newUser): ?>
        <div class="margin-b20 clearfix">
            <?=$form->textField($newUser, 'first_name', array('class' => 'itx-simple', 'placeholder' => 'Ваше имя'))?>
            <?=$form->error($newUser, 'first_name')?>
        </div>
        <div class="margin-b20 clearfix">
            <?=$form->textField($newUser, 'email', array('class' => 'itx-simple', 'placeholder' => 'Ваш e-mail'))?>
            <?=$form->error($newUser, 'email')?>
        </div>
    <?php endif; ?>
    <div class="clearfix">
        <button class="btn-blue btn-h46 float-r">Задать вопрос </button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var CommunityQuestion = function() {
        var self = this;
        self.title = ko.observable('');
    }

    $(function() {
        var model = new CommunityQuestion();
        ko.applyBindings(model, document.getElementById('blog-form'));
    });
</script>
<?php $this->endWidget(); ?>