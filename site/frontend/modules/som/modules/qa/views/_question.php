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
        <div class="icons-meta_view"><span class="icons-meta_tx"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($data->url)?></span></div>
    </div>
    <div class="clearfix"></div><a class="questions_item_heading" href="<?=$data->url?>"><?=CHtml::encode($data->title)?></a>
    <div class="questions_item_category">
        <div class="questions_item_category_ico sharp-test"></div>
        <?php if ($data->consultationId === null): ?>
            <a href="<?=$this->createUrl('/som/qa/default/index/', array('categoryId' => $data->category->id))?>" class="questions_item_category_link"><?=$data->category->title?></a>
        <?php else: ?>
            <a href="<?=$this->createUrl('/som/qa/consultation/index/', array('consultationId' => $data->consultation->id))?>" class="questions_item_category_link"><?=$data->consultation->title?></a>
        <?php endif; ?>
    </div>
    <?php if ($data->answersCount == 0): ?>
        <?php if (Yii::app()->user->checkAccess('createQaAnswer', array('question' => $data))): ?>
            <a class="questions_item_answers" href="<?=$data->url?>"><span class="questions_item_answers_ans">ответить</span></a>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($data->isFromConsultation()): ?>
            <a class="questions_item_answers" href="<?=$data->url?>">
                <div class="questions_item_answers_img">
                    <span class="ava ava__small ava__<?=($data->lastAnswer->user->gender) ? 'male' : 'female'?>">
                        <?php if ($data->lastAnswer->user->avatarUrl): ?>
                            <img alt="" src="<?=$data->lastAnswer->user->avatarUrl?>" class="ava_img">
                        <?php endif; ?>
                    </span>
                </div>
                <span class="questions_item_answers_text">ответ</span>
            </a>
        <?php else: ?>
            <a class="questions_item_answers" href="<?=$data->url?>">
                <span class="questions_item_answers_text"><?=$data->answersCount?> <?=Str::GenerateNoun(array('ответ', 'ответа', 'ответов'), $data->answersCount)?></span>
            </a>
        <?php endif; ?>
    <?php endif; ?>
    <div class="clearfix"></div>
</li>