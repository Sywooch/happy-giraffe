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
    <title>КОМЬЮНИТИ</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport">
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <meta content="telephone=no" name="format-detection">
    <meta content="176" name="/Optimized">

    <?php Yii::app()->clientScript
        ->registerCoreScript('jquery')
        ->registerScriptFile('/javascripts/comet.js')

        ->registerScriptFile('/javascripts/knockout-2.2.1.js')
        ->registerCssFile('/stylesheets/seo2/all.css?r=14')
        ->registerScriptFile('/javascripts/dklab_realplexor.js')
        ->registerScriptFile('/javascripts/seo2/jquery.fancybox.pack.js')
        ->registerScriptFile('/javascripts/seo2/main.js')
        ->registerScript('Realplexor-reg', 'comet.connect("http://' . Yii::app()->comet->host . '", "' . Yii::app()->comet->namespace . '","' . UserCache::GetCurrentUserCache() . '");');

    $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
    Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'script.js?r=14', CClientScript::POS_BEGIN);
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

                    <div class="header-page_title">КОМЬЮНИТИ</div>
                    <div class="header-page_date"><?=Yii::app()->dateFormatter->format('d MMMM yyyy', time())?></div>
                </div>
            </div>

            <nav class="header-nav">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'encodeLabel' => false,
                    'htmlOptions' => array('class' => 'header-nav_ul'),
                    'items' => array(
                        array(
                            'label' => '<span class="header-nav_tx">Задания</span>',
                            'url' => array('commentator/index'),
                            'linkOptions' => array('class' => 'header-nav_i'),
                            'itemOptions' => array('class' => 'header-nav_li header-nav_li__tasks'),
                            'active' => (Yii::app()->controller->action->id == 'index')
                        ),
                        array(
                            'label' => '<span class="header-nav_tx">Ссылки</span>',
                            'url' => array('commentator/links'),
                            'linkOptions' => array('class' => 'header-nav_i'),
                            'itemOptions' => array('class' => 'header-nav_li header-nav_li__links'),
                            'active' => (Yii::app()->controller->action->id == 'links')
                        ),
                        array(
                            'label' => '<span class="header-nav_tx">Новые люди</span>',
                            'url' => array('commentator/users'),
                            'linkOptions' => array('class' => 'header-nav_i'),
                            'itemOptions' => array('class' => 'header-nav_li header-nav_li__new-peoples'),
                            'active' => (Yii::app()->controller->action->id == 'users')
                        ),
                        array(
                            'label' => '<span class="header-nav_tx">Отчеты</span>',
                            'url' => array('commentator/reports'),
                            'linkOptions' => array('class' => 'header-nav_i'),
                            'itemOptions' => array('class' => 'header-nav_li header-nav_li__reports'),
                            'active' => (Yii::app()->controller->action->id == 'reports')
                        ),
                        array(
                            'label' => '<span class="header-nav_tx">Премия</span>',
                            'url' => array('commentator/award'),
                            'linkOptions' => array('class' => 'header-nav_i'),
                            'itemOptions' => array('class' => 'header-nav_li header-nav_li__award'),
                            'active' => (Yii::app()->controller->action->id == 'award')
                        ),
                        array(
                            'label' => '<span class="header-nav_tx">Секреты</span>',
                            'url' => array('commentator/secrets'),
                            'linkOptions' => array('class' => 'header-nav_i'),
                            'itemOptions' => array('class' => 'header-nav_li header-nav_li__secrets'),
                            'active' => (Yii::app()->controller->action->id == 'secrets')
                        ),
                        array(
                            'label' => '<span class="header-nav_tx">Команда</span>',
                            'url' => array('commentator/team'),
                            'linkOptions' => array('class' => 'header-nav_i'),
                            'itemOptions' => array('class' => 'header-nav_li header-nav_li__team'),
                            'active' => (Yii::app()->controller->action->id == 'team'),
                            'visible' =>$this->commentator->chief == 1
                        ),
                    ),
                ));

                ?>
            </nav>
        </div>

        <?= $content ?>

    </div>
</div>


</body>
</html>