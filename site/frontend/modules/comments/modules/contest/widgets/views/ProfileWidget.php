<?php
/**
 * @var $contest
 * @var $participant
 */
?>

<div class="w-contest-commentator"><a href="javascript:void(0)" onclick="var link = this; $.post('/ajax/setUserAttribute/', {key: '<?=$this->getAttributeKey()?>', value: '1'}, function() {$(link).parent().hide();});" class="w-contest-commentator_close">Скрыть</a>
    <div class="w-contest-commentator_date"><?=Yii::app()->dateFormatter->format('d MMMM', $contest->startDate)?> - <?=Yii::app()->dateFormatter->format('d MMMM', $contest->endDate)?></div>
    <h2 class="w-contest-commentator_t">Лучший комментатор</h2>
    <div class="w-contest-commentator_in">
        <?php if ($participant->score > 0): ?>
            <div class="w-contest-commentator_place"><?=$participant->place?></div>
        <?php endif; ?>
        <div class="w-contest-commentator_user">
            <?php $this->widget('Avatar', array(
                'user' => $participant->user,
            )); ?>
        </div>
        <div class="w-contest-commentator_count">
            <a href="#" class="w-contest-commentator_buble"></a><?=$participant->score?>
        </div>
    </div>
    <div class="w-contest-commentator_btn-hold">
        <?php if (Yii::app()->user->id == $this->userId): ?>
            <a href="<?=Yii::app()->createUrl('/comments/contest/default/my', array('contestId' => $contest->id))?>" class="btn btn-xxl btn-link">Моя лента</a>
        <?php endif; ?>
        <a href="<?=Yii::app()->createUrl('/comments/contest/default/rating', array('contestId' => $contest->id))?>" class="btn btn-xxl btn-default">Весь рейтинг</a>
    </div>
</div>