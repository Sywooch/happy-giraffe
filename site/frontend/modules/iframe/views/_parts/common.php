<?php
/**
 * @var PersonalAreaController $this
 */
?><!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
 <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title><?=$this->pageTitle?></title>
        <meta content="" name="description" />
        <meta content="" name="keywords" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="telephone=no" name="format-detection" />
        <meta name="HandheldFriendly" content="true" />

        <!--[if (gt IE 9)|!(IE)]><!-->
        <!-- <link href="static/css/main.min.css" rel="stylesheet" type="text/css"> -->
        <!--<![endif]-->
        <meta property="og:title" content="Happy Girafe" />
        <meta property="og:title" content="" />
        <meta property="og:url" content="" />
        <meta property="og:description" content="" />
        <meta property="og:image" content="" />
        <meta property="og:image:type" content="image/jpeg" />
        <meta property="og:image:width" content="500" />
        <meta property="og:image:height" content="300" />
        <meta property="twitter:description" content="" />
        <link rel="image_src" href="" />
        <link rel="icon" type="image/x-icon" href="/favicon.bmp" />
        <script>
            (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)
        </script>
     <style>
         .notice-header-kids__icon{
             display: inline-block;
             vertical-align: middle;
             background-image: url("/app/builds/static/img/pediatrician/kids.svg");
             background-repeat: no-repeat;
             background-size: contain;
             width: 24px;
             height: 24px;
             margin-right: 10px;
         }
         .notice-header-kids__icon-big{
             display: block;
             margin: 0 auto;
             width: 192px;
             height: 192px;
             background-image: url("/app/builds/static/img/pediatrician/kids.svg");
             background-repeat: no-repeat;
             background-size: contain;
             opacity: 0.1;
             margin-top: 60px;
         }
         .cap-empty-iframe_t{
             font-size: 14px;
             color: rgba(0,0,0,0.4);
         }
         .cap-empty-ifram_tx-sub{
             margin-top: 50px;
         }
         .cap-empty-ifram_tx-sub .btn{
             font-size: 14px;
             padding: 14px 70px;
             border-radius: 50px;
         }
     </style>
    </head>

     <body class="page--bg page-iframe--bg">
        <div class="js-overlay-menu overlay-menu"></div>
        <div class="js-overlay-user overlay-user"></div>
        <?php Yii::app()->ads->showCounters(); ?>
        <div class="b-layout b-container b-container--white b-container--style">
        	<?php //Yii::app()->ads->showCounters(); ?>
        	<?php if (Yii::app()->user->checkAccess('editMeta')):?>
                <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
            <?php endif ?>
            	<div id="js-alerts" class="alerts" data-bind="template: { name: 'alert', foreach: alertsList }"></div>
                <script type="text/html" id="alert">
	               <div class="alert alert-in" data-bind="css: 'alert-' + color">
                        <div class="position-rel">
                            <div class="alert__container">
                                <div class="alert__ico" data-bind="css: 'alert__ico-' + color"></div>
                                <div class="alert__text" data-bind="css: 'alert__text-' + color, text: message"></div>
                            </div>
                            <span class="alert__close" data-bind="click: $parent.closeAlert, css: 'alert__close-' + color"></span>
                        </div>
                    </div>
                </script>

                    <?= $content ?>
                    <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
            <div class="popup-container display-n">
            </div>
            <!--[if lt IE 9]> <script type="text/javascript" src="/lite/javascript/respond.min.js"></script> <![endif]-->
        </div>
    </body>
</html>
