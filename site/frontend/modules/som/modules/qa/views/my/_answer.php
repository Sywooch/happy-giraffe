<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $data
 */
?>

<a class="popup-widget_cont_heading" href="<?=$data->question->url?>"><?=CHtml::encode($data->question->title)?></a>
<ul class="answers-list <?=($data->isBest) ? 'best-answer' : 'all-answers'?>">
    <?php $this->renderPartial('/_answer', compact('data')); ?>
</ul>