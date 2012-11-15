<?php $this->beginContent('//layouts/main'); ?>

<?php
$section = 2;
if (isset($_GET['section']))
    $section = $_GET['section'];

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript
    ->registerScriptFile($baseUrl . '/cook.js')
    ->registerScript('set_section', 'CookModule.section='.$section.';var content_section='.$section.';');

?>
<div class="clearfix">
    <div class="default-nav">

        <?php
        if (Yii::app()->user->checkAccess('cook-manager-panel'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Ключевые слова',
                        'url' => ($section == 2) ? $this->createUrl('/competitors/default/index', array('section' => $section)) : $this->createUrl('/cook/editor/index', array('section' => $section)),
                        'active' => Yii::app()->controller->uniqueId == 'competitors/default' || (Yii::app()->controller->uniqueId == 'cook/editor' && Yii::app()->controller->action->id == 'index')
                    ),
                    array(
                        'label' => 'По названию',
                        'url' => $this->createUrl('/cook/editor/name', array('section' => $section)),
                        'active' => Yii::app()->controller->action->id == 'name'
                    ),
                    array(
                        'label' => 'Раздача заданий',
                        'url' => $url = $this->createUrl('/cook/editor/tasks', array('section' => $section)),
                        'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="'.$url.'">' . SeoTask::taskCount($section) . '</a></div>',
                        'active' => Yii::app()->controller->action->id == 'tasks'
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => $this->createUrl('/cook/editor/reports', array('section' => $section)),
                        'active' => Yii::app()->controller->action->id == 'reports'
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