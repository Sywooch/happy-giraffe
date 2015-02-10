<?php
/**
 * @var $this site\frontend\modules\ads\components\renderers\PostRenderer
 */
?>
<!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Happy Giraffe</title>
    <!-- css для теста, что вообще такие стили существуют-->
    <!-- в рабочей реализации не использовать-->
    <!--link(rel='stylesheet', type='text/css', href='/lite/css/dev/all.css')-->
    <!-- livereload-->
    <script src="//localhost:35729/livereload.js"></script>
    <!-- Встраивать стили из файла-->
    <link rel="stylesheet" type="text/css" href="/lite/css/min/article-anonce.css">
</head>
<!--/ layout out-->
<body>
<!-- Варианты цветов блока
article-anonce__green
article-anonce__blue
article-anonce__lilac
article-anonce__red
article-anonce__yellow
-->
<div class="article-anonce article-anonce__yellow">
    <div class="article-anonce_top">
        <a href="<?=$this->user->profileUrl?>" class="article-anonce_header-a">
            <span class="ava"><img alt="<?=$this->user->fullName?>" src="<?=$this->user->avatarUrl?>" class="ava_img"></span>
            <span class="article-anonce_author"><?=$this->user->fullName?></span>
        </a>
    </div>
    <a href="%%CLICK_URL_UNESC%%" class="article-anonce_hold">
        <div class="article-anonce_img-hold">
            <img src="<?=Yii::app()->thumbs->getThumb($this->getPhoto(), 'postAnnouncement')?>" alt="<?=$this->model->title?>" class="article-anonce_img">
            <div class="article-anonce_img-overlay"></div>
        </div>
        <div class="article-anonce_bottom">
            <!-- может быть, а может и не быть тег название клуба-->
            <div class="article-anonce_tag"><?=$this->getClubTitle()?></div>
            <div class="article-anonce_t"><?=$this->model->title?>
            </div>
        </div>
    </a>
</div>
</body></html>