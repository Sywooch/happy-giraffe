<?php
/**
 * @var site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget $this
 * @var site\frontend\modules\family\models\FamilyMemberAbstract $member
 */
?>

<div class="family-member_about-in">
    <div class="family-member_about-hold">
        <div class="ico-family-big ico-family-big__<?=$member->getViewData()->getCssClass()?>"></div>
        <div class="family-member_about-name"><?=$member->getViewData()->getTitle()?></div>
    </div>
    <?php if ($member->description): ?>
        <div class="family-member_about-tx-hold">
            <div class="family-member_about-tx"><?=$member->description?></div>
        </div>
    <?php endif; ?>
</div>