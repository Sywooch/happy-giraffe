<?php
/**
 * @var \site\frontend\modules\family\widgets\FamilyMemberWidget\FamilyMemberWidget $this
 */
$familyCollection = $this->model->family->getPhotoCollection('all');
$attach = $familyCollection->observer->getByAttach($this->model->photoCollection->observer->getSingle(0));
?>

<div class="family-member_row clearfix">
    <?php if ($this->model->photoCollection->observer->getCount() > 0): ?>
        <?php if ($this->getPhotoSide() == $this::PHOTO_SIDE_LEFT): ?>
            <?php $this->render('_full_photo', array('member' => $this->model)); ?>
            <div style="width: <?=$this->getInfoWidth()?>px;" class="family-member_about family-member_about__<?=$this->getColor()?> family-member_about__right">
                <?php $this->render('_full_info', array('member' => $this->model, 'attach' => $attach)); ?>
            </div>
        <?php else: ?>
            <div style="width: <?=$this->getInfoWidth()?>px;" class="family-member_about family-member_about__<?=$this->getColor()?> family-member_about__left">
                <?php $this->render('_full_info', array('member' => $this->model)); ?>
            </div>
            <?php $this->render('_full_photo', array('member' => $this->model, 'attach' => $attach)); ?>
        <?php endif; ?>
    <?php else: ?>
        <div style="width: 100%;" class="family-member_about family-member_about__<?=$this->getColor()?>">
            <?php $this->render('_full_info', array('member' => $this->model)); ?>
        </div>
    <?php endif; ?>
</div>