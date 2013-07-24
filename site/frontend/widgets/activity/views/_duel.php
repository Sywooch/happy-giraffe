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
                            <a href="javascript:;" onclick="Duel.showVotes();" class="tooltip" title="Посмотреть голоса">голосов</a>
                        </div>
                        <div class="button">
                            <?php if (! Yii::app()->user->isGuest): ?>
                                    <?php if ($answers[$i]->getCurrentVote(Yii::app()->user->id) !== null): ?>
                                        <span>Мой голос</span><br />
                                    <?php endif; ?>
                                    <?php if (! $question->getCanVote(Yii::app()->user->id) || ($answers[0]->getCurrentVote(Yii::app()->user->id) !== null || $answers[1]->getCurrentVote(Yii::app()->user->id) !== null)): ?>
                                        <a class="active" disabled="disabled">Голосовать</a>
                                    <?php else: ?>
                                        <a href="javascript:;" onclick="Duel.vote(this, <?=$answers[$i]->id?>);">Голосовать</a>
                                    <?php endif; ?>
                            <?php else: ?>
                                <a class="fancy" href="#login" data-theme="white-square">Голосовать</a>
                            <?php endif; ?>
                        </div>
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
                        <div class="more-votes">еще <?=($answers[$i]->votes - 20)?> <?=Str::GenerateNoun(array('голос', 'голоса', 'голосов'), $answers[$i]->votes - 20)?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
