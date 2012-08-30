<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>КОМЬЮНИТИ</title>

    <?php Yii::app()->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile('/javascripts/comet.js')
    ->registerScriptFile('/javascripts/jquery.placeholder.min.js')
    ->registerCssFile('/stylesheets/seo.css')
    ->registerScriptFile('/javascripts/jquery.pnotify.min.js')
    ->registerCssFile('/stylesheets/jquery.pnotify.css')
    ->registerScriptFile('/javascripts/dklab_realplexor.js')
    ->registerScript('Realplexor-reg', '
    comet.connect("http://' . Yii::app()->comet->host . '", "' . Yii::app()->comet->namespace . '",
                  "' . UserCache::GetCurrentUserCache() . '");
');
    $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
    Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'script.js', CClientScript::POS_BEGIN);

    ?>
</head>
<body>

<div id="seo" class="wrapper">
    <div class="clearfix">
        <div class="default-nav">
            <ul>
                <?php if ($this->commentator->IsWorksToday(Yii::app()->user->id)):?>
                    <li><span class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy',time())?></span></li>
                    <li<?php if (Yii::app()->controller->action->id == 'index') echo ' class="active"'; ?>><a href="<?=$this->createUrl('/signal/commentator/index') ?>">Задания</a>
                        <?php if (Yii::app()->controller->action->id == 'index'):?>
                            <span class="tale"><img src="/images/default_nav_active.gif"></span>
                        <?php endif ?>
                    </li>
                <?php else: ?>
                    <li><span class="date"><?=Yii::app()->dateFormatter->format('dd MMM yyyy',time())?></span><button class="btn-green-27" onclick="CommentatorPanel.iAmWorking();">Я сегодня работаю</button></li>
                <?php endif ?>
                <li<?php if (Yii::app()->controller->action->id == 'statistic') echo ' class="active"'; ?>><a href="<?=$this->createUrl('/signal/commentator/statistic') ?>">Премия</a>
                    <?php if (Yii::app()->controller->action->id == 'statistic'):?>
                        <span class="tale"><img src="/images/default_nav_active.gif"></span>
                    <?php endif ?>
                </li>
            </ul>
        </div>

        <div class="title">
            <i class="statistic-img"></i> КОМЬЮНИТИ
        </div>

    </div>

    <?php echo $content ?>

</div>
</body>
</html>
