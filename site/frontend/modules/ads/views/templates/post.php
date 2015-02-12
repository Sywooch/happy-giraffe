<?php
/**
 * @var $this site\frontend\modules\ads\components\creatives\PostCreative
 */
?>
<!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Happy Giraffe</title>
    <link rel="stylesheet" type="text/css" href="http://www.happy-giraffe.ru/lite/css/min/article-anonce.css">
</head>
<!--/ layout out -->
<body>
<div class="article-anonce article-anonce__red<?php if ($this->size == $this::SIZE_BIG): ?> article-anonce__xl<?php endif; ?>">
    <div class="article-anonce_top">
        <a href="<?=$this->model->user->profileUrl?>" class="article-anonce_header-a">
            <span href="#" class="ava"><img alt="<?=$this->model->user->fullName?>" src="<?=$this->model->user->avatarUrl?>" class="ava_img"></span>
            <span class="article-anonce_author"><?=$this->model->user->fullName?></span>
        </a>
    </div>
    <a href="%%DEST_URL%%" class="article-anonce_hold">
        <div class="article-anonce_img-hold">
            <?php if ($this->size == $this::SIZE_BIG && $this->getPhotosCount() > 0): ?>
                <div class="article-anonce_img-top">
                    <div class="article-anonce_count-hold">
                        <div class="article-anonce_count-t"><?=$this->getPhotosCount()?></div>
                        <div class="article-anonce_count-tx">фото</div>
                    </div>
                </div>
            <?php endif; ?>
            <img src="<?=Yii::app()->thumbs->getThumb($this->getPhoto(), ($this->size == $this::SIZE_BIG) ? 'postAnnouncementBig' : 'postAnnouncement')?>" alt="<?=$this->model->title?>" class="article-anonce_img">
            <div class="article-anonce_img-overlay"></div>
        </div>
        <div class="article-anonce_bottom">
            <div class="article-anonce_tag"><?=$this->getClubTitle()?></div>
            <div class="article-anonce_t"><?=$this->model->title?>
            </div>
        </div>
    </a>
</div>
</body></html>