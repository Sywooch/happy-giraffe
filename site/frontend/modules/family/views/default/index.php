<?php
/**
 * @var LiteController $this
 * @var site\frontend\modules\family\models\Family $family
 * @var integer $userId
 */
$this->metaNoindex = true;
$this->breadcrumbs = array(
    'Семья',
);
if ($this->owner->id == Yii::app()->user->id) {
    $this->pageTitle = 'Моя семья';
} else {
    $this->pageTitle = 'Семья - ' . $this->owner->fullName;
}

$familyCollection = $family->getPhotoCollection('all');
$attach = $familyCollection->observer->getByAttach($family->photoCollection->observer->getSingle(0));
?>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user">
        <div class="textalign-c">
            <div class="ico-myfamily ico-myfamily__l"></div>
        </div>
        
        <?php if ($this->owner->id == Yii::app()->user->id): ?>
            <div class="family-user_edit-hold"> 
                <a href='<?=$this->createUrl('/family/default/fill', array('userId' => $userId))?>' class="btn btn-secondary btn-l"><div class="ico-edit ico-edit__s"></div>&nbsp;Редактировать</a>
            </div>
        <?php endif; ?>

        <?php if ($attach !== null): ?>
            <?php $this->renderPartial('_mainPhoto', array('attach' => $attach)); ?>
        <?php endif; ?>
        <!-- family-about-->
        <div class="family-about">
            <?php if ($family->description): ?>
                <div class="family-about_bubble">
                    <div class="family-about_t">О нашей семье</div>
                    <div class="family-about_tx"><?=$family->description?></div>
                </div>
            <?php endif; ?>
            <?php $this->widget('site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget', array(
                'family' => $family,
                'view' => 'short',
                'me' => $userId,
            )); ?>
        </div>
        <!-- /family-about-->
        <div class="visible-md">
            <!-- family-member-->
            <?php $this->widget('site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget', array(
                'family' => $family,
                'view' => 'full',
                'me' => $userId,
            )); ?>
            <!-- /family-member-->
            <!-- <div class="i-allphoto"> <a href="" class="i-allphoto_a">Смотреть семейный альбом</a></div> -->
        </div>
    </div>
</div>