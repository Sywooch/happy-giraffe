<?php
/**
 * @var $this site\frontend\modules\ads\components\creatives\PhotoPostCreative
 */
?>
<!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Happy Giraffe</title>
    <link rel="stylesheet" type="text/css" href="http://beta.happy-giraffe.ru/lite/css/min/article-anonce.css">
</head>
<!--/ layout out -->
<body>
<div class="article-anonce article-anonce__color-<?=$this->getOriginEntity()->rubric->community->club->section_id?> article-anonce__ico">
    <div class="article-anonce_top">
        <a target="_top" href="<?=$this->model->user->profileUrl?>" class="article-anonce_header-a">
            <span href="#" class="ava"><img alt="<?=$this->model->user->fullName?>" src="<?=$this->model->user->avatarUrl?>" class="ava_img"></span>
            <span class="article-anonce_author"><?=$this->model->user->fullName?></span>
        </a>
    </div>
    <a target="_top" href="%%CLICK_URL_UNESC%%%%DEST_URL%%" class="article-anonce_hold">
        <div class="article-anonce_ico-hold">
            <div class="article-anonce_ico-a">
                <div class="article-anonce_ico"><img src="<?=$this->iconSrc?>" alt="<?=$this->model->title?>" class="article-anonce_img"></div>
                <div class="article-anonce_tag"><?=$this->getClubTitle()?></div>
                <span class="article-anonce_t"><?=$this->model->title?></span>
            </div>
            <div class="article-anonce_img-overlay"></div>
        </div>
    </a>
</div>
</body></html>