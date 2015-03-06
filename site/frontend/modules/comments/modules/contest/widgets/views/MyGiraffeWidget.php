<?php
/**
 * @var $contest
 * @var $leaders
 */
?>

<div class="b-article clearfix">
    <div class="w-contest-commentator giraffe"><a href="javascript:void(0)" onclick="var link = this; $.post('/ajax/setUserAttribute/', {key: '<?=$this->getAttributeKey()?>', value: '1'}, function() {$(link).parent().hide();});" class="w-contest-commentator_close">Скрыть</a>
        <div class="w-contest-commentator_date"><?=Yii::app()->dateFormatter->format('d MMMM', $contest->startDate)?> - <?=Yii::app()->dateFormatter->format('d MMMM', $contest->endDate)?></div>
        <h2 class="w-contest-commentator_t">Лучший комментатор</h2>
        <div class="w-contest-commentator_t-sub">Лидеры конкурса</div>
        <div class="w-contest-commentator_avas">
            <ul class="ava-list">
                <?php foreach ($leaders as $l): ?>
                    <li class="ava-list_li">
                        <?php $this->widget('Avatar', array(
                            'user' => $l->user,
                        )); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php if (Yii::app()->user->isGuest || ! $contest->isRegistered(Yii::app()->user->id)): ?>
            <div class="w-contest-commentator_btn-hold">
                <a href="<?=Yii::app()->createUrl('/comments/contest/default/index', array('contestId' => $contest->id))?>" class="btn btn-xxl btn-link">Принять участие!</a>
            </div>
        <?php endif; ?>
    </div>
</div>