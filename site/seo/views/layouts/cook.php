<?php $this->beginContent('//layouts/main');?>

<?php
$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/cook.js');
?>
<div class="clearfix">
    <div class="default-nav">

        <?php
        if (Yii::app()->user->checkAccess('cook-manager-panel'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Рукоделие',
                        'url' => $this->createUrl('/cook/cook/index', array('theme'=>5)),
                        'active'=> Yii::app()->controller->action->id == 'index' && Yii::app()->request->getParam('theme') == 5
                    ),
                    array(
                        'label' => 'Интерьер',
                        'url' => $this->createUrl('/cook/cook/index', array('theme'=>6)),
                        'active'=> Yii::app()->controller->action->id == 'index' && Yii::app()->request->getParam('theme') == 6
                    ),
                    array(
                        'label' => '1. Конкуренты',
                        'url' => $this->createUrl('/competitors/default/index', array('section'=>2)),
                        'active'=>Yii::app()->controller->uniqueId == 'competitors/default'
                    ),
                    array(
                        'label' => '2. Рецепты',
                        'url' => array('/cook/cook/recipes'),
                    ),
                    array(
                        'label' => 'Раздача заданий',
                        'url' => array('/cook/cook/tasks/'),
                        'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/cook/cook/tasks') . '">' . ( TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) + SeoTask::model()->count('owner_id=' . Yii::app()->user->id.' AND executor_id IS NULL') ). '</a></div>',
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/cook/cook/reports/'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('cook-author'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/cook/author/index'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/cook/author/reports'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('cook-content-manager'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/cook/content/index'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/cook/content/reports'),
                    ),
                )));

        ?>
    </div>

    <?php $this->renderPartial('//layouts/_header'); ?>

</div>
<?php echo $content; ?>

<?php $this->endContent(); ?>