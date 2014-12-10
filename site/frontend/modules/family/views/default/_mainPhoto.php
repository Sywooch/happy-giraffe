<?php
/** @var \ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerAMD('familyPhoto', array('ko' => 'knockout', 'kow' => 'kow', 'sliderBinding' => 'extensions/sliderBinding'), 'ko.applyBindings({}, document.getElementById("familyPhoto"));')
?>

<section class="b-album">
    <div class="b-album_img-hold">
        <!-- Загружать просмотрщик -->
        <a href="#" class="b-album_img-a" data-bind="photoSlider: { photo: <?=$attach->id?>, collectionId: <?=$familyCollection->id?> }" id="familyPhoto">
            <div class="b-album_img-pad"></div>
            <div class="b-album_img-picture">
                <img src="<?=Yii::app()->thumbs->getThumb($attach->photo, 'familyMainPhoto')?>" alt="Фото" class="b-album_img-big">
            </div>
            <div class="b-album_img-hold-ovr">
                <div class="ico-zoom ico-zoom__abs"></div>
            </div>
        </a>
    </div>
</section>