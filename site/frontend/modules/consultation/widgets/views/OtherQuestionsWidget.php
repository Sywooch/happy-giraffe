<?php
/**
 * @var \site\frontend\modules\consultation\models\ConsultationAnswer[] $questions
 * @var int $count
 */
?>

<div class="b-consult-aside">
    <div class="b-consult-aside__title">Другие вопросы <a href="<?=Yii::app()->controller->createUrl('index', array('slug' => $this->question->consultation->slug))?>" class="b-consult-aside__title__all">Все вопросы <?=$count?></a></div>
    <?php foreach ($questions as $question): ?>
    <div class="b-consult-aside-item">
        <a href="<?=$question->user->profileUrl?>" class="b-consult-aside-item__ava"><img src="<?=$question->user->avatarUrl?>" alt=""></a>
        <a href="<?=$question->user->profileUrl?>" class="b-article_author"><?=$question->user->fullName?></a>
        <?=HHtml::timeTag($question, array('class' => 'tx-date'), null) ?>
        <div class="b-consult-aside-item__message">
            <div class="b-consult-qa-ms__message__title"><?=$question->title?></div>
            <?=$question->text?>
        </div>
    </div>
    <?php endforeach; ?>
</div>