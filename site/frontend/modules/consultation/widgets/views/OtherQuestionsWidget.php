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
        <a href="<?=$question->user->profileUrl?>" class="ava ava__small b-consult-aside-item__ava"><span class="ico-status ico-status__online"></span><img src="<?=$question->user->avatarUrl?>" alt=""></a>
        <a href="<?=$question->user->profileUrl?>" class="b-article_author"><?=$question->user->fullName?></a>
        <?=HHtml::timeTag($question, array('class' => 'tx-date'), null) ?>
        <div class="b-consult-aside-item__message">
            <a href="<?=$question->getUrl()?>" class="b-consult-qa-ms__message__title"><?=$question->title?></a>
            <?=\site\common\helpers\HStr::truncate(strip_tags($question->text), 300)?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
