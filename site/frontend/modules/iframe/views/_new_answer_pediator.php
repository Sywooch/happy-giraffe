<?php
/**
 * @var \site\frontend\modules\iframe\models\QaCTAnswer $data
 */
$urlUser = $this->createUrl('/iframe/userProfile/default/index',['userId'=>$data->author->id]);
 ?>
 <div class="b-pediator-answer__left">
    <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
        <a href="<?=$urlUser?>" class="ava ava--theme-pedaitor ava--medium ava--medium_male">
            <img src="<?=$data->author->getAvatarUrl(40)?>" class="ava__img" />
        </a>
    </div>
</div>
<div class="b-pediator-answer__right">
    <div class="b-answer__header b-answer-header">
    	<a href="<?=$urlUser?>" class="b-answer-header__link"><?=$data->user->getFullName()?></a>
        <?=HHtml::timeTag($data, array('class' => 'b-answer-header__time'))?>
        <div class="b-answer-header__spezialisation"><?=$data->author->specialistProfile->getSpecsString()?></div>
    </div>
    <div class="b-answer__body b-answer-body">
        <p class="b-pediator-answer__text"><?=strip_tags($data->text)?></p>
        <a href="<?=$data->question->url?>" class="b-text--link-color b-title--bold b-title--h9"><?=strip_tags($data->question->title)?></a>
    </div>
</div>