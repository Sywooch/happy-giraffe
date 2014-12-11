<?php
/**
 * @var site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget $this
 * @var site\frontend\modules\family\models\FamilyMemberAbstract $member
 */
$familyCollection = $member->family->getPhotoCollection('all');
$attach = $familyCollection->observer->getByAttach($member->photoCollection->observer->getSingle(0));

var_dump($attach);
die;

$id = 'familyMember' . $member->id;

/** @var \ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerAMD($id, array('ko' => 'knockout', 'kow' => 'kow', 'sliderBinding' => 'extensions/sliderBinding'), 'ko.applyBindings({}, document.getElementById("' . $id . '"));');
?>

<a href="#" class="family-member_i" data-bind="photoSlider: { photo: <?=$attach->id?>, collectionId: <?=$familyCollection->id?> }" id="<?=$id?>">
    <img src="<?=Yii::app()->thumbs->getThumb($attach->photo, 'familyMemberImage')?>" alt="" class="family-member_img">
    <div class="family-member_overlay"><span class="ico-zoom ico-zoom__abs"></span></div>
</a>