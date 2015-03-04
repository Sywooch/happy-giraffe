<?php
/**
 * @var $this->contest
 * @var $this->participant
 */
?>

<div class="w-contest-commentator">
    <div class="w-contest-commentator_date"><?=Yii::app()->dateFormatter->format('d MMMM', $this->contest->startDate)?> - <?=Yii::app()->dateFormatter->format('d MMMM', $this->contest->endDate)?></div>
    <h2 class="w-contest-commentator_t">Лучший комментатор</h2>
    <div class="w-contest-commentator_in">
        <?php if ($this->participant->score > 0): ?>
            <div class="w-contest-commentator_place"><?=$this->participant->place?></div>
        <?php endif; ?>
        <div class="w-contest-commentator_user">
            <?php $this->widget('Avatar', array(
                'user' => $this->participant->user,
            )); ?>
        </div>
        <div class="w-contest-commentator_count">
            <a href="#" class="w-contest-commentator_buble"></a><?=$this->participant->score?>
        </div>
    </div>
    <div class="w-contest-commentator_btn-hold">
        <?php if (Yii::app()->user->id == $this->userId): ?>
            <a href="<?=Yii::app()->createUrl('/comments/contest/default/my', array('contestId' => $this->contest->id))?>" class="btn btn-xxl btn-link">Моя лента</a>
        <?php endif; ?>
        <a href="<?=Yii::app()->createUrl('/comments/contest/default/rating', array('contestId' => $this->contest->id))?>" class="btn btn-xxl btn-default">Весь рейтинг</a>
    </div>
</div>