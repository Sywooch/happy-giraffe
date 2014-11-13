<?php
/**
 * @var LiteController $this
 * @var site\frontend\modules\family\models\Family $family
 * @var site\frontend\modules\family\models\FamilyMember[] $members
 */
?>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user">
        <div class="ico-myfamily"></div>
        <div class="family-user_main-img-hold">
            <!-- У изображений соотношения сторон сохраняются -->
            <!-- 0,65 соотношение сторон-->
            <picture class="b-album_img-picture">
                <source srcset="/lite/images/example/photoalbum/2-960.jpg 1x, /lite/images/example/photoalbum/1-1920.jpg 2x" media="(min-width: 640px)"><img src="/lite/images/example/photoalbum/1-1280.jpg" alt="Фото" class="b-album_img-big">
            </picture>
        </div>
        <!-- family-about-->
        <div class="family-about">
            <?php if ($family): ?>
            <div class="family-about_bubble">
                <div class="family-about_t">О нашей семье</div>
                <div class="family-about_tx"><?=$family->description?></div>
            </div>
            <?php endif; ?>
            <?php $this->widget('site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget', array(
                'family' => $family,
                'view' => 'short',
            )); ?>
        </div>
        <!-- /family-about-->
        <div class="visible-md">
            <!-- family-member-->
            <?php $this->widget('site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget', array(
                'family' => $family,
                'view' => 'full',
            )); ?>
            <!-- /family-member-->
            <div class="i-allphoto"> <a href="" class="i-allphoto_a">Смотреть семейный альбом</a></div>
        </div>
    </div>
</div>