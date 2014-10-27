<?php
/**
 * @var LiteController $this
 */
?>
<!DOCTYPE html><!--[if lt IE 10]>     <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js "> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->pageTitle?></title>
    <?=CHtml::linkTag('shortcut icon', null, '/favicon.bmp')?>
</head>
<body class="body body__lite theme theme__adfox <?php if ($this->bodyClass !== null): ?> <?=$this->bodyClass?><?php endif; ?> <?php if (Yii::app()->user->isGuest): ?> body__guest <?php else: ?>  body__user<?php endif; ?>">
<?php Yii::app()->ads->showCounters(); ?>
<?php if (Yii::app()->user->checkAccess('editMeta')):?>
    <a id="btn-seo" href="/ajax/editMeta/?route=<?=urlencode(Yii::app()->controller->route) ?>&params=<?=urlencode(serialize(Yii::app()->controller->actionParams)) ?>" class="fancy" data-theme="white-square"></a>
<?php endif ?>
<div class="layout-container">
    <div class="layout-loose layout-loose__white">
        <div class="layout-header">
            <?php if (Yii::app()->user->isGuest): ?>
                <?php $this->renderPartial('//_header_guest'); ?>
            <?php  else: ?>
                <?php $this->renderDynamic(array($this, 'renderPartial'), '//_menu', null, true); ?>
            <?php endif; ?>
        </div>
        <?= $content ?>
        <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
    </div>
</div>
<div class="popup-container display-n">
</div>
<!--[if lt IE 9]> <script type="text/javascript" src="/lite/javascript/respond.min.js"></script> <![endif]-->
<script type="text/javascript">
    require(['lite']);
</script>
<?php if (Yii::app()->user->isGuest): ?>
    <?php $this->widget('site.frontend.modules.signup.widgets.LayoutWidget'); ?>
<?php endif; ?>
</body></html>