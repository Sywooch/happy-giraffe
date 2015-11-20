<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $data
 */
?>

<li class="questions_item">
    <div class="live-user">
        <a href="<?=$data->user->profileUrl?>" class="ava ava__small ava__<?=($data->user->gender) ? 'male' : 'female'?>">
            <?php if ($data->user->avatarUrl): ?>
                <img alt="" src="<?=$data->user->avatarUrl?>" class="ava_img">
            <?php endif; ?>
        </a>
        <div class="username">
            <a href="<?=$data->user->profileUrl?>"><?=$data->user->getFullName()?></a>
            <?= HHtml::timeTag($data, array('class' => 'tx-date')); ?>
        </div>
    </div>
    <div class="icons-meta">
        <div class="icons-meta_view"><span class="icons-meta_tx"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits()?></span></div>
    </div>
    <div class="clearfix"></div><a class="questions_item_heading"><?=$data->title?></a>
    <div class="questions_item_category">
        <div class="questions_item_category_ico sharp-test"></div><a href="<?=$this->createUrl('/som/qa/default/index/', array('categoryId' => $data->category->id))?>" class="questions_item_category_link"><?=$data->category->title?></a>
    </div>
    <?php if ($data->answersCount == 0): ?>
        <a class="questions_item_answers"><span class="questions_item_answers_ans">ответить</span></a>
    <?php else: ?>
        <a class="questions_item_answers"><span class="questions_item_answers_text"><?=$data->answersCount?> ответов</span></a>
    <?php endif; ?>
    <div class="clearfix"></div>
</li>