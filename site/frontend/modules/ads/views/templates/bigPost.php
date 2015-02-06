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
    <style>
        html {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
            font: 12px/18px Arial,Tahoma,Verdana,sans-serif;
            height: 100%;
            -webkit-font-smoothing: antialiased;
        }

        body {
            margin: 0;
            font: 12px/18px Arial,Tahoma,Verdana,sans-serif;
            color: #333;
            background-color: #fff;
            word-wrap: break-word;
            word-break: break-word;
            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            hyphens: auto;
        }

        img {
            border: 0;
            max-width: 100%;
            vertical-align: middle;
        }

        *,:after,:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            box-sizing: border-box;
        }

        a {
            background: 0 0;
            color: #289FD7;
            text-decoration: none;
            cursor: pointer;
        }
        a:hover {
            color: #ff6900;
            text-decoration: none;
        }

        a:focus {
            outline: 0;
        }

        @-ms-viewport {
            width:device-width;
        }

        ::-moz-selection {
            background: #b3d4fc;
            text-shadow: none;
        }

        ::selection {
            background: #b3d4fc;
            text-shadow: none;
        }


        .ava {
            display: inline-block;
            background: url('http://www.happy-giraffe.ru/lite/images/base/ava.png') no-repeat -240px -480px;
        }

        .ava,.ava_img {
            position: relative;
            width: 72px;
            height: 72px;
            border-radius: 36px;
        }

        .ava_img {
            display: block;
            max-height: 100%;
        }
        .ico-more,
        .ico-more-hover,
        .ico-ovrPlay,
        .ico-plus,
        .ico-zoom,
        a.ico-more:hover {
            background-size: 120px 360px;
        }
        .no-svg .ico-more,
        .no-svg .ico-more-hover,
        .no-svg .ico-ovrPlay,
        .no-svg .ico-plus,
        .no-svg .ico-zoom {
            background-image: url("http://www.happy-giraffe.ru/lite/images/sprite/ico-base.png");
        }
        .ico-more,
        .ico-more-hover,
        .ico-ovrPlay,
        .ico-plus,
        .ico-zoom,
        a.ico-more:hover {
            background-image: url("http://www.happy-giraffe.ru/lite/images/sprite/ico-base.svg");
        }
        .ico-ovrPlay {
            width: 99px;
            height: 99px;
            background-position: 0 -80px;
        }
        .ico-ovrPlay__abs {
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -50px 0 0 -50px;
        }
        .ico-ovrPlay__s {
            -webkit-transform: scale(0.6);
            -ms-transform: scale(0.6);
            -o-transform: scale(0.6);
            transform: scale(0.6);
        }
        .article-anonce__xl .article-anonce_img-hold:before,
        .article-anonce_ico-hold:before {
            content: "";
            display: inline-block;
            min-height: inherit;
            height: 100%;
            vertical-align: middle;
            margin: 0 -3px 0 0;
        }


        /* article-anonce */
        .article-anonce {
            position: relative;
            display: block;
            vertical-align: top;
            margin: 0;
            text-align: left;
        }
        .article-anonce .ico-ovrPlay__s {
            position: relative;
            float: right;
            top: -10px;
            right: -10px;
        }
        .article-anonce__xl {
            width: 615px;
        }
        .article-anonce__xl .article-anonce_img-hold {
            height: 410px;
            overflow: hidden;
        }
        .article-anonce__xl .article-anonce_img {
            vertical-align: middle;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            /*height: 100%;*/
            width: 100%;
        }
        .article-anonce__xl .article-anonce_hold:hover .article-anonce_t {
            color: #fff;
        }
        .article-anonce__xl .article-anonce_bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            border: none;
            padding-bottom: 20px;
            background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.7) 100%);
            background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.7) 100%);
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.7) 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#b3000000', GradientType=0);
        }
        .article-anonce__xl .article-anonce_t {
            font-size: 30px;
            line-height: 30px;
            color: #fff;
            margin-right: 130px;
        }
        .article-anonce__xl .article-anonce_img-top {
            top: auto;
            bottom: 15px;
            right: 20px;
            background: none;
        }
        .article-anonce__xl .article-anonce_count-t {
            font-size: 50px;
        }
        .article-anonce__xl .article-anonce_count-tx {
            font-size: 23px;
        }
        .article-anonce__green .article-anonce_hold {
            border-color: #52b547;
        }
        .article-anonce__green .article-anonce_tag {
            background-color: #52b547;
        }
        .article-anonce__blue .article-anonce_hold {
            border-color: #47aef3;
        }
        .article-anonce__blue .article-anonce_tag {
            background-color: #47aef3;
        }
        .article-anonce__lilac .article-anonce_hold {
            border-color: #8970b4;
        }
        .article-anonce__lilac .article-anonce_tag {
            background-color: #8970b4;
        }
        .article-anonce__red .article-anonce_hold {
            border-color: #ff8232;
        }
        .article-anonce__red .article-anonce_tag {
            background-color: #ff8232;
        }
        .article-anonce__yellow .article-anonce_hold {
            border-color: #facf32;
        }
        .article-anonce__yellow .article-anonce_tag {
            background-color: #facf32;
        }
        .article-anonce_top {
            position: relative;
            margin: 0 12px 7px;
            padding-top: 16px;
        }
        .article-anonce_top .ava {
            position: absolute;
            top: 0;
            left: 0;
            border: 2px solid #fff;
            z-index: 5;
        }
        .article-anonce_author {
            display: block;
            padding: 0 20px 0 75px;
            width: 100%;
            text-decoration: none;
            -ms-text-overflow: ellipsis;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            line-height: 12px;
            /*max-width: 150px;*/
        }
        .article-anonce_hold {
            display: block;
            border-top: 5px solid #8970b4;
        }
        .article-anonce_hold:hover .article-anonce_t {
            color: #ff6900;
        }
        .article-anonce_hold:hover .article-anonce_img {
            opacity: 0.8;
            filter: alpha(opacity=80);
        }
        .article-anonce_bottom {
            position: relative;
            padding: 10px 15px 10px;
            border: 1px solid #f2f2f2;
            border-top: none;
        }
        .article-anonce_t {
            margin: 5px 0;
            font-size: 22px;
            line-height: 1em;
            letter-spacing: -0.15px;
            font-weight: bold;
            color: #196eb9;
        }
        .article-anonce_tag {
            position: absolute;
            top: -12px;
            left: 15px;
            padding: 1px 10px;
            color: #fff;
            font-weight: bold;
            background-color: #8970b4;
        }
        .article-anonce_img-hold {
            position: relative;
            background-color: #fff;
            text-align: center;
        }
        .article-anonce_img {
            width: 100%;
        }
        .article-anonce_img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 2;
            background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
            background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3000000', endColorstr='#00000000', GradientType=0);
        }
        .article-anonce_count-hold {
            margin: 15px;
            float: right;
            color: #fff;
            text-align: center;
        }
        .article-anonce_count-t {
            font-size: 34px;
            line-height: 1em;
        }
        .article-anonce_count-tx {
            font-size: 15px;
            line-height: 1em;
        }
        .article-anonce_text {
            padding: 30px 12px 20px;
            font-size: 14px;
        }
        .article-anonce__ico.article-anonce__green .article-anonce_hold {
            background-color: #52b547;
        }
        .article-anonce__ico.article-anonce__blue .article-anonce_hold {
            background-color: #47aef3;
        }
        .article-anonce__ico.article-anonce__lilac .article-anonce_hold {
            background-color: #8970b4;
        }
        .article-anonce__ico.article-anonce__red .article-anonce_hold {
            background-color: #ff8232;
        }
        .article-anonce__ico.article-anonce__yellow .article-anonce_hold {
            background-color: #facf32;
        }
        .article-anonce__ico .article-anonce_img {
            width: auto;
        }
        .article-anonce__ico .article-anonce_tag {
            position: relative;
            top: auto;
            left: auto;
        }
        .article-anonce__ico .article-anonce_t {
            margin: 10px 20px;
            color: #fff;
            display: inline-block;
        }
        .article-anonce__ico .article-anonce_hold:hover .article-anonce_t {
            color: #fff;
            opacity: 0.7;
            filter: alpha(opacity=70);
        }
        .article-anonce_ico-hold {
            height: 410px;
            text-align: center;
            overflow: hidden;
        }
        .article-anonce_ico-a {
            display: inline-block;
            vertical-align: middle;
        }
        .article-anonce_ico {
            margin: 20px 0 15px;
        }
        /* /article-anonce */
    </style>
</head>
<!--/ layout out -->
<body>
<!-- Варианты цветов блока
article-anonce__green
article-anonce__blue
article-anonce__lilac
article-anonce__red
article-anonce__yellow
-->
<div class="article-anonce article-anonce__red article-anonce__xl">
    <div class="article-anonce_top"><a href="%%CLICK_URL_UNESC%%" class="article-anonce_header-a">
            <!-- ava--><span href="#" class="ava"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><span class="article-anonce_author">Марина Правдинина</span></a></div><a href="#" class="article-anonce_hold">
        <div class="article-anonce_img-hold">
            <div class="article-anonce_img-top">
                <div class="article-anonce_count-hold">
                    <div class="article-anonce_count-t">128</div>
                    <div class="article-anonce_count-tx">фото</div>
                </div>
            </div><img src="<?=Yii::app()->thumbs->getThumb()?>" alt="Наши первые движения они родились в разных странах " class="article-anonce_img">
        </div>
        <div class="article-anonce_bottom">
            <!-- может быть, а может и не быть тег-->
            <div class="article-anonce_tag"><?=$this->getClubTitle()?></div>
            <div class="article-anonce_t"><?=$this->model->title?>
            </div>
        </div></a>
</div>
</body></html>