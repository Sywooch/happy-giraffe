<?php
/**
 * @var CommunityContent $model
 * @var CommunityQuestion $slaveModel
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'question-form',
    'action' => array('/community/default/save'),
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
    </div>
    <div class="margin-b20 clearfix">
        <?=$form->textArea($slaveModel, 'text', array('class' => 'itx-simple', 'placeholder' => 'Ваш вопрос', 'cols' => '30', 'rows' => '5'))?>
    </div>
    <div class="clearfix">
        <button class="btn-blue btn-h46 float-r">Задать вопрос </button>
    </div>
</div>

<script type="text/javascript">
    var CommunityQuestion = function() {
        var self = this;
        self.title = ko.observable('');
    }

    $(function() {
        var model = new CommunityQuestion();
        ko.applyBindings(model, document.getElementById('question-form'));
    });
</script>

<?php $this->endWidget(); ?>