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
                <?php if ($i % 2 != 0): ?>
                    <?php $this->render('_full_info', array('member' => $member)); ?>
                <?php endif; ?>
                <a href="#" class="family-member_i">
                    <img src="/lite/images/example/w350-h450-1.jpg" alt="" class="family-member_img">
                    <div class="family-member_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
                </a>
                <div style="width: 530px;" class="family-member_about family-member_about__green family-member_about__<?=($i % 2 == 0) ? 'right' : 'left'?>">
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
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>