<?php

use site\frontend\modules\som\modules\qa\models\qaTag\Enum;

/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaCTAnswer $data
 */
?>
<li class="b-answer__item">
    <div class="b-pediator-answer">
    	<div class="b-pediator-answer__left">
            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                <a href="<?=$data->author->getUrl()?>" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
                    <img src="<?=$data->author->getAvatarUrl(40)?>" class="ava__img" />
                </a>
            </div>
        </div>
        <?php if ($data->authorIsSpecialist()) {
            $this->renderPartial('/_new_answer_pediator', ['data' => $data]);
        } else {
            $this->renderPartial('/_new_answer_user', ['data' => $data]);
        } ?>
         <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
            <div class="b-pedaitor-answer__footer__item">
            	<a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tagId' => $data->question->tag->id])?>" class="b-answer-footer__age b-text--link-color"><?=(new Enum())->getTitleForWeb($data->question->tag->name)?></a>
            </div>
            <div class="b-pedaitor-answer__footer__item"><a href="javascript:void(0);" class="b-answer-footer__comment"><?=$data->getQuestion()->getAnswerManager()->getAnswersCount()?></a>
                <?php if (\Yii::app()->user->isGuest) { ?>
            		<button type="button" class="btn-answer btn-answer--theme-green btn-answer--active login-button" data-bind="follow: {}">
                    	<span class="btn-answer__num btn-answer__num--theme-green">Спасибо <?=$data->votes_count?></span>
                    </button>
    			<?php } else { ?>
    				<pediatrician-vote params="count: <?=$data->votes_count?>, answerId:<?=$data->id?>"></pediatrician-vote>
    			<?php } ?>
            </div>
        </div>
	</div>
</li>