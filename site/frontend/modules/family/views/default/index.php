<?php
/**
 * @var LiteController $this
 * @var site\frontend\modules\family\models\Family $family
 * @var integer $userId
 */
$this->breadcrumbs = array(
    'Семья',
);
?>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user">
        <div class="ico-myfamily"></div>
        <?php if ($attach = $family->photoCollection->observer->getSingle(0)): ?>
            <div class="family-user_main-img-hold">
                <img src="<?=Yii::app()->thumbs->getThumb($attach->photo, 'familyMainPhoto')?>" class="b-album_img-picture">
            </div>
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
            <div class="i-allphoto"> <a href="" class="i-allphoto_a">Смотреть семейный альбом</a></div>
        </div>
    </div>
</div>