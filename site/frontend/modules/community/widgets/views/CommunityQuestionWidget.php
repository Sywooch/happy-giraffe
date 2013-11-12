<?php
/**
 * @var CommunityContent $model
 * @var CommunityQuestion $slaveModel
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'blog-form',
    'action' => array('/community/default/save'),
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
        <?=$form->textField($model, 'title', array('class' => 'itx-simple', 'placeholder' => 'Тема вопроса', 'data-bind' => 'value: title, valueUpdate: \'keyup\', click: guest'))?>
        <?=$form->error($model, 'title')?>
    </div>
    <div class="margin-b20 clearfix">
        <?=$form->textArea($slaveModel, 'text', array('class' => 'itx-simple', 'placeholder' => 'Ваш вопрос', 'cols' => '30', 'rows' => '5', 'data-bind' => 'click: guest'))?>
        <?=$form->error($slaveModel, 'text')?>
    </div>
    <div class="clearfix">
        <button class="btn-blue btn-h46 float-r" data-bind="click: guest">Задать вопрос </button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var CommunityQuestion = function() {
        var self = this;
        self.title = ko.observable('');

        self.guest = function() {
            if (CURRENT_USER_ID === null)
                $('[href="#login"]').trigger('click');
            else
                return true;
        }
    }

    $(function() {
        var model = new CommunityQuestion();
        ko.applyBindings(model, document.getElementById('blog-form'));
    });
</script>