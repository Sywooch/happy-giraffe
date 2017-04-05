<?php

/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer $data
 * @var boolean $hasVote
 */
?>

<div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">

    <div class="b-pedaitor-answer__footer__item">
        <?php if($data->question && $data->question->tag): ?>
            <a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tab' => 'new', 'tagId' => $data->question->tag->id])?>" class="b-answer-footer__age b-text--link-color"><?=$data->question->tag->getTitle()?></a>
        <?php endif; ?>
    </div>

    <?php if ($data->authorId == \Yii::app()->user->id): ?>

        <div class="b-pedaitor-answer__footer__item">
        	<?php if ($data->descendantsCount() > 0) {?>
        		<a href="javascript:void(0);" class="b-answer-footer__comment"><?=$data->descendantsCount()?></a>
        	<?php } ?>
            <button type="button" class="btn-answer btn-answer--theme-grey">
                <span class="btn-answer__num btn-answer__num--to">Вам сказали &nbsp;</span>
                <span class="btn-answer__num btn-answer__num--theme-grey">Спасибо <?= $data->votesCount?></span>
            </button>
        </div>

    <?php else: ?>

        <div class="b-pedaitor-answer__footer__item">
        	<?php if ($data->descendantsCount() > 0) {?>
        		<a href="javascript:void(0);" class="b-answer-footer__comment"><?=$data->descendantsCount()?></a>
        	<?php } ?>
            <?php if (\Yii::app()->user->isGuest) { ?>
                <button type="button" class="btn-answer btn-answer--theme-green login-button <?=$hasVote ? 'btn-answer--active' : ''?>" data-bind="follow: {}">
                    <span class="btn-answer__num btn-answer__num--theme-green">Спасибо <?= $data->votesCount?></span>
                </button>
            <?php } else { ?>
                <pediatrician-vote params="count: <?=$data->votesCount?>, answerId: <?=$data->id?>, hasVote: <?=$hasVote ? 1:0?>"></pediatrician-vote>
            <?php } ?>
        </div>

    <?php endif; ?>

</div>