<?php
/**
 * @var site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget $this
 * @var site\frontend\modules\family\models\FamilyMemberAbstract[] $members
 */
?>

<div class="family-member">
    <?php foreach ($members as $i => $member): ?>
        <?php if (! $this->isMe($member)): ?>
            <div class="family-member_row clearfix">
                <?php if ($member->photoCollection->observer->getCount() > 0): ?>
                    <?php if ($i % 2 != 0): ?>
                        <?php $this->render('_full_photo', array('member' => $member)); ?>
                        <div style="width: 530px;" class="family-member_about family-member_about__<?=$this->getColor()?> family-member_about__right">
                            <?php $this->render('_full_info', array('member' => $member)); ?>
                        </div>
                    <?php else: ?>
                        <div style="width: 530px;" class="family-member_about family-member_about__<?=$this->getColor()?> family-member_about__left">
                            <?php $this->render('_full_info', array('member' => $member)); ?>
                        </div>
                        <?php $this->render('_full_photo', array('member' => $member)); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div style="width: 100%;" class="family-member_about family-member_about__<?=$this->getColor()?>">
                        <?php $this->render('_full_info', array('member' => $member)); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>