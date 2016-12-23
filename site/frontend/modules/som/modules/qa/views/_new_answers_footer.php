<?php

/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var site\frontend\modules\som\modules\qa\models\QaCTAnswer $data
 * @var boolean $myAnswersPage
 * @var boolean $hasVote
 */

?>

<div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">

    <?php if (! is_null($data->question->tag)): ?>

        <div class="b-pedaitor-answer__footer__item">
            <a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tab' => 'new', 'tagId' => $data->question->tag->id])?>" class="b-answer-footer__age b-text--link-color"><?=$data->question->tag->getTitle()?></a>
        </div>

    <?php endif; ?>

    <?php if ($myAnswersPage): ?>

        <div class="b-pedaitor-answer__footer__item"><a href="javascript:void(0);" class="b-answer-footer__comment">10</a>
            <button type="button" class="btn-answer btn-answer--theme-grey">
                <span class="btn-answer__num btn-answer__num--to">Вам сказали &nbsp;</span>
                <span class="btn-answer__num btn-answer__num--theme-grey">Спасибо <?= $data->getVotesCount(); ?></span>
            </button>
        </div>

    <?php else: ?>

        <div class="b-pedaitor-answer__footer__item"><a href="javascript:void(0);" class="b-answer-footer__comment"><?=$data->getQuestion()->answersCount; ?></a>
            <?php if (\Yii::app()->user->isGuest) { ?>
                <button type="button" class="btn-answer btn-answer--theme-green login-button <?=$hasVote ? 'btn-answer--active' : ''?>" data-bind="follow: {}">
                    <span class="btn-answer__num btn-answer__num--theme-green">Спасибо <?= $data->getVotesCount(); ?></span>
                </button>
            <?php } else { ?>
                <pediatrician-vote params="count: <?=$data->getVotesCount()?>, answerId: <?=$data->id?>, hasVote: <?=$hasVote ? 1:0?>"></pediatrician-vote>
            <?php } ?>
        </div>

    <?php endif; ?>

</div>