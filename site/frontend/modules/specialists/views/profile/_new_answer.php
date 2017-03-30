<?php

/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $data
 * @var \site\frontend\modules\users\models\User $user
 */

// @todo: Вынести от сюда в модель/декоратор/...
$fullName = Str::ucFirst($user->first_name) . ' ' . Str::ucFirst($user->last_name);

?>

<li class="b-answer__item">
    <div class="b-pediator-answer">
        <div class="b-pediator-answer__left">
            <div class="b-pediator-answer__ava b-pediator-answer__ava--theme-pink">
                <span class="ava ava--style ava--medium ava--medium_male">
                    <img src="<?= $user->getAvatarUrl(Avatar::SIZE_SMALL); ?>" class="ava__img" />
                </span>
            </div>
        </div>
        <div class="b-pediator-answer__right">
            <div class="b-answer__header b-answer-header">
                <a href="javascript:void(0);" class="b-answer-header__link"><?= $fullName; ?></a>
                <?= HHtml::timeTag($data, ['class' => 'b-answer-header__time']); ?>
                <div class="b-answer-header__spezialisation"><?= $data->user->specialistInfo['title']; ?></div>
            </div>
            <div class="b-answer__body b-answer-body">
                <p class="b-pediator-answer__text"><?= strip_tags($data->text); ?></p>
                <a href="<?= $data->question->url; ?>" target="_blank" class="b-text--link-color b-title--bold b-title--h9"><?= $data->question->title; ?></a>
            </div>
        </div>
        <div class="b-pedaitor-answer__footer b-answer-footer b-answer-footer--pink">
            <div class="b-pedaitor-answer__footer__item">

                <?php if (!is_null($data->question->tag)): ?>

                <a href="<?= $data->question->tag->getUrl(); ?>" target="_blank" class="b-answer-footer__age b-text--link-color"><?= $data->question->tag->getTitle(); ?></a>

                <?php endif; ?>

            </div>
            <div class="b-pedaitor-answer__footer__item">
                <a href="javascript:void(0);" class="b-answer-footer__comment"><?= $data->descendantsCount(); ?></a>
                <pediatrician-vote params="count: <?= $data->votesCount; ?>, answerId: <?= $data->id; ?>, hasVote: <?= (bool) $data->votes; ?>"></pediatrician-vote>
            </div>
        </div>
    </div>
</li>