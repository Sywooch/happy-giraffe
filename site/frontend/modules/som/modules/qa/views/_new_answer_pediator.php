<?php

use site\frontend\modules\som\modules\qa\models\qaTag\Enum;

/**
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
        <div class="b-pediator-answer__right b-pediator-answer__right--pink">
            <div class="b-answer__header b-answer-header">
            	<a href="<?=$data->author->getUrl()?>" class="b-answer-header__link"><?=$data->user->getFullName()?></a>
                <?=HHtml::timeTag($data, array('class' => 'b-answer-header__time'))?>
                <div class="b-answer-header__spezialisation"><?=$data->author->specialistProfile->getSpecsString()?></div>
                <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\answers\AnswerHeaderWidget', [
                    'userId' => $data->author->id,
                ]);?>
            </div>
            <div class="b-answer__body b-answer-body">
                <p class="b-pediator-answer__text"><?=strip_tags($data->text)?></p>
                <a href="<?=$data->question->url?>" class="b-text--link-color b-title--bold b-title--h9"><?=strip_tags($data->question->title)?></a>
            </div>
        </div>
        <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
            <div class="b-pedaitor-answer__footer__item">
            	<a href="<?=$this->createUrl('/som/qa/default/pediatrician', ['tagId' => $data->question->tag->id])?>" class="b-answer-footer__age b-text--link-color"><?=(new Enum())->getTitleForWeb($data->question->tag->name)?></a>
            </div>
            <div class="b-pedaitor-answer__footer__item"><a href="javascript:void(0);" class="b-answer-footer__comment"><?=$data->getQuestion()->getAnswerManager()->getAnswersCount()?></a>
                <button type="button" class="btn-answer btn-answer--theme-green btn-answer--active">
                	<span class="btn-answer__num btn-answer__num--theme-green">Спасибо 98</span>
                </button>
            </div>
        </div>
    </div>
</li>