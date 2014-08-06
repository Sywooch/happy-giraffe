<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Happy Giraffe</title>
    <!-- including .css--><link rel="stylesheet" type="text/css" href="/new/css/all1.css" />

</head>
<body class="body body__white">
<div class="layout-container">
    <div class="layout-header">
        <!-- header-->
        <div class="header header__small">
            <div class="header_hold clearfix">
            </div>
        </div>
        <!-- /header-->
    </div>
    <div class="layout-wrapper">
        <div class="layout-wrapper_frame clearfix">
            <div class="layout-content clearfix">
                <div class="content-cols clearfix">
                    <div class="utilites-error">
                        <div class="utilites-error_hold">
                            <div class="utilites-error_404"></div>
                            <div class="utilites-error_title">Извините, страница не существует</div>
                            <div class="utilites-error_sub-tx">или была удалена</div><a href="<?=Yii::app()->homeUrl?>" class="btn-arrow btn-arrow__next btn-l btn-green-simple"><span class="btn-arrow_ico"><i class="ico-arrow-r"></i></span><span class="btn-arrow_tx">На главную страницу</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Yii::app()->ads->showCounters(); ?>
</body>
</html>