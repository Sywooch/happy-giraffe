<?php
/**
 * @var site\frontend\modules\som\modules\qa\controllers\DefaultController $this
 * @var site\frontend\modules\som\modules\qa\models\QaAnswer $data
 * @var site\frontend\modules\som\modules\qa\components\QaObjectList $additionalData
 */

$hasVote = FALSE;
if (isset($additionalData['votesList']))
{
    $voteList = $additionalData['votesList']->sortedByField('answerId', $data->id);
    $hasVote = !$voteList->isEmpty();
}
?>
<article class="b-answer__item">
    <div class="b-pediator-answer">
    	<div class="b-pediator-answer__left">
            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                <a href="<?=$data->author->getUrl()?>" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
                    <img src="<?=$data->author->getAvatarUrl(40)?>" class="ava__img" />
                </a>
            </div>
        </div>
        <?php if ($data->authorIsSpecialist()) {
            $this->renderPartial('site.frontend.modules.som.modules.qa.views._new_answer_pediator', ['data' => $data]);
        } else {
            $this->renderPartial('site.frontend.modules.som.modules.qa.views._new_answer_user', ['data' => $data]);
        } ?>
        <?php $this->renderPartial('site.frontend.modules.som.modules.qa.views._new_answers_footer', [
            'data'          => $data,
            'hasVote'       => $hasVote,
        ]) ?>
	</div>
</article>