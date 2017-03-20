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
         .page-iframe--bg{
             background-image: none;
             background-color: #f0f0f0;
         }
         .header-iframe--bg{
             background-color: #645091;
             background-image: none;
         }
        .header-iframe__logo{
            background-position: -7px -228px;
            width: 45px;
            background-size: 112px auto;
            height: 50px;
        }
        .header-iframe_loged{
            width: 340px;
            z-index: 2;
        }
        .header-iframe_loged .js-ava__link{
            margin-top: 5px;
            display: inline-block;
        }
        .header-iframe__menu--style{
            text-align: left;
            padding-left: 125px;
            left: 145px;
            width: auto;
        }
         a.header-iframe__link{
             color: #FFFFFF;
             opacity: 0.4;
         }
         .header-iframe__link:hover,
         .header-iframe__link:focus,
         .header-iframe__li--active .header-iframe__link{
             opacity: 1;
         }
         .header-iframe__link:after{
             content: "";
             display: block;
             position: absolute;
             background-position: center;
             width: 22px;
             height: 21px;
             background-repeat: no-repeat;
             top: 2px;
             left: 50%;
             -webkit-transform: translate(-50%, 0);
             transform: translate(-50%, 0);
         }
         .header-iframe__link.header__link--doc:after{
             background-image: url("/app/builds/static/img/pediatrician/doctors.svg");
         }
         .header-iframe__link.header__link--answer:after{
             background-image: url("/app/builds/static/img/pediatrician/questions.svg");
         }
         .b-main-iframe{
             padding-top: 35px;
             padding-bottom: 130px;
         }
         .b-filter-search-iframe__submit{
             position: absolute;
             opacity: 0.3;
             right: 20px;
             top: 0;
         }
         .b-filter-search-iframe__submit:after {
             -webkit-transform: scale(1);
             transform: scale(1);
         }
         .b-filter-year-iframe__icon{
             display: block;
             width: 100%;
             height: 2px;
             background-color: rgba(0,0,0,1);
             -webkit-transition: all .3s;
             transition: all .3s;
             -webkit-backface-visibility: hidden;
             backface-visibility: hidden;
             border-radius: 2px;
             opacity: 0.3;
         }
         .b-filter-year-iframe__icon:before,
         .b-filter-year-iframe__icon:after{
             content: "";
             display: block;
             position: absolute;
             width: 100%;
             height: 2px;
             background-color: rgba(0,0,0,1);
             -webkit-transition: all .3s;
             transition: all .3s;
             -webkit-backface-visibility: hidden;
             backface-visibility: hidden;
             border-radius: 2px;
         }
         .b-filter-year-iframe__icon:before{
             top: 5px;
         }
         .b-filter-year-iframe__icon:after{
             top: 10px;
         }
         .b-filter-year-iframe {
             position: relative;
             display: inline-block;
             width: 18px;
             height: 12px;
             right: 35px;
             cursor: pointer;
         }
         .b-filter-year-iframe:hover .b-filter-year-iframe__icon,
         .b-filter-year-iframe:focus .b-filter-year-iframe__icon{
             opacity: 1;
         }
         .b-filter-search-iframe__form {
             display: block;
             min-width: 45px;
         }
         .b-filter-search-iframe__input{
             display: none;
         }
         .b-filter-search-iframe__input.b-filter-search__input--active{
             display: block;
         }
         .b-filter-year-iframe-menu{
             position: absolute;
             display: block;
             top: 24px;
             right: 0;
             padding: 20px;
             overflow: hidden;
             visibility: hidden;
             opacity: 0;
             width: 240px;
             height: 230px;
             background-color: #ffffff;
             cursor: default;
             box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.09);
             -webkit-transition: opacity 100ms,top 100ms linear,visibility 100ms linear;
             transition: opacity 100ms,top 100ms linear,visibility 100ms linear;
         }
         .b-filter-year-iframe-menu_open {
             visibility: visible;
             opacity: 1;
             z-index: 11;
         }
         .b-user-box-iframe{
             padding: 28px 12px;
             display: table;
             height: auto;
         }
         .b-user-box-iframe .b-user-box__item{
             display: table-row;
         }
         .b-user-box-iframe .b-user-box__num{
             display: table-cell;
             vertical-align: top;
             font-size: 32px;
             padding-left: 37px;
             background-size: auto 36px;
             background-repeat: no-repeat;
             background-position: center left;
         }
         .b-user-box-iframe .b-user-box__num--green{
             padding-top: 25px;
             background-image: url("/app/builds/static/img/assets/user-box/flover.svg");
             background-size: auto 30px;
             background-position: bottom 5px left 9px;
         }
         .b-user-box-iframe .b-user-box__num--black{
             background-image: url("/app/builds/static/img/pediatrician/mama.svg");
         }
         .b-user-box-iframe .b-user-box__text{
             display: table-cell;
             padding-left: 15px;
         }
         .b-user-box-iframe .b-user-box__item:last-child .b-user-box__text{
             padding-top: 25px;
         }
         .footer-iframe.footer--style{
             height: 90px;
             padding: 34px 0;
         }
         .footer-iframe .footer__li{
             font-size: 14px;
             color: rgba(0,0,0,0.4);
             margin-right: 70px;
         }
         .footer-iframe .footer__link{
             color: rgba(0,0,0,0.4);
             transition: all .4s ease-in-out;
         }
         .footer-iframe .footer__link:hover,
         .footer-iframe .footer__link:focus{
             color: rgba(0,0,0,1);
         }
         .footer-iframe .footer-app__li{
             color: rgba(0,0,0,0.4);
             font-size: 14px;
             float: right;
             margin-right: 0;
         }
         .footer-iframe .footer-app-links{
             display: inline-block;
         }
         .footer-iframe .footer-app-links>a{
             display: inline-block;
             vertical-align: top;
             width: 15px;
             height: 18px;
             background-repeat: no-repeat;
             background-position: center;
             background-size: contain;
             opacity: 0.25;
             margin-left: 16px;
             transition: all .4s ease-in-out;
         }
         .footer-app-links__android{
            background-image: url("/app/builds/static/img/pediatrician/apps/android.svg");
         }
         .footer-app-links__ios{
             background-image: url("/app/builds/static/img/pediatrician/apps/apple.svg");
         }
         .footer-iframe .footer-app-links>a:hover,
         .footer-iframe .footer-app-links>a:focus{
             opacity: 1;
         }
     </style>
     <script>
         $(document).ready(function () {
             $('.b-filter-year-iframe').on('click',function(){
                 $('.b-filter-year-iframe-menu')
                     .toggleClass('b-filter-year-iframe-menu_open');
             });
         });
     </script>
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
