<div id="duel-takeapart" class="popup">

    <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>

    <div id="duel_step_1">
        <div class="title">Выберите вопрос-дуэль, в которой<br/>Вы хотели бы поучаствовать</div>

        <ul class="duels-list">
            <?php foreach ($questions as $i => $q): ?>
                <li class="clearfix">
                    <div class="text">
                        <p><a href="javascript:;" onclick="Duel.select(this, <?=$q->id?>);"><span class="num"><?=++$i?></span><?=$q->text?></a></p>
                        <?php if ($q->answers): $q = $q->answers[0]; ?>
                            <div class="duelist clearfix">
                                <span class="label">Ожидает дуэлянта:</span>
                                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $q->user, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="duel_step_2" style="display: none;">
        <div class="title"></div>

        <div class="add-answer">

            <?php $form = $this->beginWidget('CActiveForm', array(
                'action' => '/ajax/duelSubmit/',
                'htmlOptions' => array(
                    'id' => 'duel_form',
                    'onsubmit' => 'Duel.submit(this); return false;',
                ),
            )); ?>
                <?=$form->hiddenField($answer, 'question_id')?>

                <label>Введите в форму Ваш вариант ответа</label>

                <?=$form->textArea($answer, 'text', array('class' => 'cap', 'onfocus' => '$(this).removeClass("cap").val("");'))?>

                <div class="note"><span>Внимание!</span> Ответ должен быть кратким не более 500 символов</div>

                <div class="bottom">
                    <a href="javascript:;" onclick="$('#duel_form').submit();" class="btn btn-green"><span><span>К дуэли!</span></span></a>
                </div>
            <?php $this->endWidget(); ?>

        </div>
    </div>

    <div id="duel_step_3" style="display: none;">

    </div>


</div>