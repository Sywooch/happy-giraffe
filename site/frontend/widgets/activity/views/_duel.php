<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/duel.js');
    $answers = $question->answers;
?>

<div class="question">
    <p><?=$question->text?></p>
    <span class="tale tale-1"></span>
    <span class="tale tale-2"></span>
</div>

<div class="answers clearfix">

    <div class="clearfix">
        <?php foreach ($answers as $i => $a): ?>
        <div class="answer-<?=++$i?>">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $a->user)); ?>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="clearfix">
        <?php foreach ($answers as $i => $a): ?>
        <div class="answer-<?=++$i?>">
            <p><?=$a->text?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($votes): ?>
        <div class="clearfix">
            <?php foreach ($answers as $i => $a): ?>
                <div class="answer-<?=$i+1?>">
                    <div class="vote">
                        <div class="count">
                            <span class="count-in"><?=$answers[$i]['votes']?></span>
                            <a href="javascript:;" onclick="Duel.showVotes();">голосов<span class="tip">Посмотреть голоса</span></a>
                        </div>
                        <?php if (! Yii::app()->user->isGuest): ?>
                            <div class="button">
                                <?php if ($answers[$i]->getCurrentVote(Yii::app()->user->id) !== null): ?>
                                    <span>Мой голос</span><br />
                                <?php endif; ?>
                                <?php if (! $question->getCanVote(Yii::app()->user->id) || ($answers[0]->getCurrentVote(Yii::app()->user->id) !== null || $answers[1]->getCurrentVote(Yii::app()->user->id) !== null)): ?>
                                    <a class="active" disabled="disabled">Голосовать</a>
                                <?php else: ?>
                                    <a href="javascript:;" onclick="Duel.vote(this, <?=$answers[0]->id?>);">Голосовать</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="clearfix" id="duel-votes" style="display:none;">
            <?php foreach ($answers as $i => $a): ?>
                <div class="answer-<?=$i+1?>">
                    <ul class="votes clearfix">
                        <?php foreach ($answers[$i]->getUsers(20) as $u): ?>
                            <?php
                                $class = 'ava small';
                                if ($u->gender !== null) $class .= ' ' . (($u->gender) ? 'male' : 'female');
                            ?>
                            <li><?=CHtml::link(CHtml::image($u->getAva('small')), $u->url, array('class' => $class))?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if ($answers[$i]->votes > 20): ?>
                        <div class="more-votes">еще <?=($answer[$i] - 20)?> голосов</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
