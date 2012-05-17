<div id="duel-takeapart" class="popup">

    <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close"><span class="tip">Закрыть</span></a>

    <div id="duel_step_1">
        <div class="title">Выберите вопрос-дуэль, в которой<br/>Вы хотели бы поучаствовать</div>

        <ul class="duels-list">
            <?php foreach ($questions as $i => $q): ?>
                <li class="clearfix">
                    <a class="num"><?=++$i?></a>
                    <div class="text">
                        <p><a href="javascript:;" onclick="Duel.select(this, <?=$q->id?>);"><?=$q->text?></a></p>
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
            )); ?>
                <?php $form->hiddenField($answer, 'question_id'); ?>

                <label>Введите в форму Ваш вариант ответа</label>

                <textarea class="cap">Блестните знаниями!</textarea>

                <textarea>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются   молочные железы, объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности происходил постепенно.</textarea>

                <div class="note"><span>Внимание!</span> Ответ должен быть кратким не более 500 символов</div>

                <div class="bottom">
                    <a href="" class="btn btn-green"><span><span>К дуэли!</span></span></a>
                </div>

            <?php $this->endWidget(); ?>

        </div>
    </div>

    <div id="duel_step_3" style="display: none;">
        <div class="activity-duel">

            <div class="title">Дуэль</div>

            <div class="question">
                <p>Давно интересующий всех вопрос. Что раньше появилось яйцо или курица?</p>
                <span class="tale tale-1"></span>
                <span class="tale tale-2"></span>
            </div>

            <div class="answers clearfix">

                <div class="clearfix">
                    <div class="answer-1">
                        <div class="user-info clearfix">
                            <a class="ava female"></a>
                            <div class="details">
                                <span class="icon-status status-online"></span>
                                <a href="" class="username">Богоявленский</a>
                                <div class="user-fast-buttons clearfix">
                                    <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                    <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="answer-2">
                        <div class="user-info clearfix">
                            <a class="ava female"></a>
                            <div class="details">
                                <span class="icon-status status-online"></span>
                                <a href="" class="username">Богоявленский</a>
                                <div class="user-fast-buttons clearfix">
                                    <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                    <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix">
                    <div class="answer-1">
                        <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, мат Желательно, чтобы набор веса при беременности происходил постепенно.</p>
                    </div>
                    <div class="answer-2">
                        <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из вных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из нескольких показателей: вес ребенка, мат Желательно, чтобы набор веса при беременности происходил постепенно.</p>
                    </div>
                </div>

                <div class="clearfix">
                    <div class="answer-1">
                        <div class="vote">
                            <div class="count">
                                <span class="count-in">56</span>
                                голосов
                            </div>
                            <div class="button">
                                <a href="">Голосовать</a>
                            </div>
                        </div>
                    </div>
                    <div class="answer-2">
                        <div class="vote">
                            <div class="count">
                                <span class="count-in">826</span>
                                голосов
                            </div>
                            <div class="button">
                                <a href="">Голосовать</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


</div>