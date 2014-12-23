<?php
/**
 * @var site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget $this
 * @var site\frontend\modules\family\models\FamilyMemberAbstract[] $members
 */
?>

<div class="family-member">
    <?php foreach ($members as $i => $member): ?>
        <?php if (! $this->isMe($member)): ?>
            <?php $this->widget('site\frontend\modules\family\widgets\FamilyMemberWidget\FamilyMemberWidget', array(
                'model' => $member,
            )); ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>