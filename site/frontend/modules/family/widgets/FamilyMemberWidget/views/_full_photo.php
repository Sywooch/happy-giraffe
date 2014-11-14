<?php
/**
 * @var site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget $this
 * @var site\frontend\modules\family\models\FamilyMemberAbstract $member
 */
$photo = $member->photoCollection->observer->getSingle(0)->photo;
?>

<a href="#" class="family-member_i">
    <img src="<?=Yii::app()->thumbs->getThumb($photo, 'familyMemberImage')?>" alt="" class="family-member_img">
    <div class="family-member_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
</a>