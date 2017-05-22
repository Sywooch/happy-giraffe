<?php
/**
 * @var site\frontend\modules\iframe\controllers\DefaultController $this
 * @var site\frontend\modules\iframe\models\QaAnswer $data
 * @var site\frontend\modules\iframe\components\QaObjectList $additionalData
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
        <?php if ($data->authorIsSpecialist()) {
            $this->renderPartial('site.frontend.modules.iframe.views._new_answer_pediator', ['data' => $data]);
        } else {
            $this->renderPartial('site.frontend.modules.iframe.views._new_answer_user', ['data' => $data]);
        } ?>
        <?php $this->renderPartial('site.frontend.modules.iframe.views._new_answers_footer', [
            'data'          => $data,
            'hasVote'       => $hasVote,
        ]) ?>
	</div>
</article>