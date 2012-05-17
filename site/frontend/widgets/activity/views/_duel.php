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

    <div class="clearfix">
        <div class="answer-1">
            <div class="vote">
                <div class="count">
                    <span class="count-in"><?=$answers[0]['votes']?></span>
                    <a href="">голосов<span class="tip">Посмотреть голоса</span></a>
                </div>
                <?php if (! Yii::app()->user->isGuest): ?>
                    <div class="button">
                        <?php if ($answers[0]->getCurrentVote(Yii::app()->user->id) !== null): ?>
                            <span>Мой голос</span>
                            <br />
                        <?php endif; ?>
                        <a href="javascript:;" onclick="Duel.vote(this, <?=$answers[0]->id?>);"<?php if ($answers[0]->getCurrentVote(Yii::app()->user->id) !== null): ?> class="active"<?php endif; ?>>Голосовать</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="answer-2">
            <div class="vote">
                <div class="count">
                    <span class="count-in">826</span>
                    <a href="">голосов<span class="tip">Посмотреть голоса</span></a>
                </div>
                <div class="button">
                    <a href="">Голосовать</a>
                </div>
            </div>
        </div>
    </div>

</div>
