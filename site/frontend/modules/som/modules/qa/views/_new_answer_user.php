<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaCTAnswer $data
 */
?>
<div class="b-pediator-answer__left">
    <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
        <a href="<?=$data->author->getUrl()?>" class="ava ava--style ava--medium ava--medium_male">
            <img src="<?=$data->author->getAvatarUrl(40)?>" class="ava__img" />
        </a>
    </div>
</div>
<div class="b-pediator-answer__right">
    <div class="b-answer__header b-answer-header">
        <a href="<?=$data->author->getUrl()?>" class="b-answer-header__link"><?=$data->user->firstName?> <?=$data->user->lastName?></a>
        <?=HHtml::timeTag($data, array('class' => 'b-answer-header__time'))?>
    	<?php $this->widget('site\frontend\modules\som\modules\qa\widgets\answers\AnswerHeaderWidget', [
            'userId' => $data->author->id,
        ]);?>
    </div>
    <div class="b-answer__body b-answer-body">
        <p class="b-pediator-answer__text"><?=strip_tags($data->text)?></p>
        <a href="<?=$data->question->url?>" class="b-text--link-color b-title--bold b-title--h9"><?=strip_tags($data->question->title)?></a>
    </div>
</div>
