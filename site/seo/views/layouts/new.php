<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>
<html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=$this->pageTitle ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="telephone=no" name="format-detection">
    <meta content="176" name="/Optimized">

    <?php Yii::app()->clientScript
        ->registerCoreScript('jquery')
        ->registerScriptFile('/js/seo.js')
        ->registerCssFile('http://www.happy-giraffe.ru/stylesheets/seo2/all.css')
        ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/knockout-2.2.1.js')
        ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/seo2/jquery.fancybox.pack.js')
        ->registerScriptFile('http://www.happy-giraffe.ru/javascripts/seo2/main.js');
    ?>
</head>
<body>
<div class="layout-page">
    <div class="layout-page_w1">
        <div class="header-page">
            <div class="clearfix">
                <div class="header-page_user">
                    <a href="/site/logout/" class="header-page_logout"></a>

                    <div class="user-info clearfix">
                        <a href="<?=$this->user->url ?>" class="ava small"><?=CHtml::image($this->user->getAva('small'))?></a>

                        <div class="user-info_details">
                            <a href="<?=$this->user->url ?>" class="user-info_username"><?=$this->user->getFullName()  ?></a>
                        </div>
                    </div>
                </div>

                <div class="header-page_logo-hold clearfix">
                    <a href="/" class="header-page_logo"></a>

                    <div class="header-page_title"><?=$this->pageTitle ?></div>
                    <div class="header-page_date"><?=Yii::app()->dateFormatter->format('d MMMM yyyy', time())?></div>
                </div>
            </div>

        <?= $content ?>

    </div>
</div>


</body>
</html>