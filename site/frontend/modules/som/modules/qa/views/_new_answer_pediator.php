<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaCTAnswer $data
 */
 ?>
 <div class="b-pediator-answer__left">
    <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
        <a href="<?=$data->author->getUrl()?>" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
            <img src="<?=$data->author->getAvatarUrl(40)?>" class="ava__img" />
        </a>
    </div>
</div>
<div class="b-pediator-answer__right b-pediator-answer__right--pink">
    <a href="<?=$data->author->getUrl()?>">
        <div class="b-answer__header b-answer-header">
            <span class="b-answer-header__link"><?=$data->user->getFullName()?></span>
            <?=HHtml::timeTag($data, array('class' => 'b-answer-header__time'))?>
            <div class="b-answer-header__spezialisation"><?=$data->author->specialistProfile->getSpecsString()?></div>
            <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\answers\AnswerHeaderWidget', [
                'userId' => $data->author->id,
            ]);?>
        </div>
    </a>
    <a href="<?=$data->question->url?>">
        <div class="b-answer__body b-answer-body">
            <p class="b-pediator-answer__text"><?=strip_tags($data->text)?></p>
            <span class="b-text--link-color b-title--bold b-title--h9"><?=strip_tags($data->question->title)?></span>
        </div>
    </a>
</div>
