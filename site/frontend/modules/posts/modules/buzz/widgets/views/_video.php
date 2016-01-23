<?php
/**
 * @var \Video $video
 */
?>

<div class="article-anonce_img-hold">
    <div class="article-anonce_img-top">
        <div class="ico-ovrPlay_video ico-ovrPlay__s"></div>
    </div>
    <img src="<?=$video->getThumbnail()?>" alt="<?=$post->title?>" class="article-anonce_img">
    <div class="article-anonce_img-overlay"></div>
</div>
