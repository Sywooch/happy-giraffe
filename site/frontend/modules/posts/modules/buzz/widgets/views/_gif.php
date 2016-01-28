<?php
/**
 * @var \site\frontend\modules\photo\models\Photo $photo
 */
?>

<div class="article-anonce_img-hold">
    <div class="article-anonce_img-top">
        <div class="ico-ovrPlay_gif ico-ovrPlay__s"></div>
    </div>
    <img src="<?=Yii::app()->thumbs->getThumb($photo, 'buzzSidebar', false, false)?>" alt="Видео: как дети видят своих родителей, когда те пьяны" class="article-anonce_img">
    <div class="article-anonce_img-overlay"></div>
</div>