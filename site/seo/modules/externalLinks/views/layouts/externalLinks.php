<?php $this->beginContent('//layouts/main');?>
<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/ext_links.js?5')->registerCoreScript('jquery.ui');
?>
<div class="clearfix">
    <div class="default-nav">

        <?php
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Сайты',
                        'url' => array('/externalLinks/sites/index'),
                        'active'=>Yii::app()->controller->id == 'sites'
                    ),
                    array(
                        'label' => 'Форумы',
                        'url' => array('/externalLinks/forums/index/'),
                        'active'=>in_array(Yii::app()->controller->id, array('forums'))
                    ),
                    array(
                        'label' => 'Блоги',
                        'url' => array('/externalLinks/blogs/index/'),
                        'active'=>in_array(Yii::app()->controller->id, array('blogs'))
                    ),
                    array(
                        'label' => 'Задания',
                        'url' => array('/externalLinks/tasks/index/'),
                    ),
                    array(
                        'label' => 'Проверка ссылок',
                        'url' => array('/externalLinks/check/index/'),
                        'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/externalLinks/check/index') . '">' . ELLink::checkCount() . '</a></div>',
                    ),
                )));

        if (Yii::app()->user->checkAccess('externalLinks-worker-panel'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Задания',
                        'url' => array('/externalLinks/tasks/index'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/externalLinks/tasks/reports/'),
                    ),
                )));

            ?>
    </div>

    <?php $this->renderPartial('//layouts/_header'); ?>

</div>
<?php echo $content; ?>

<?php $this->endContent(); ?>