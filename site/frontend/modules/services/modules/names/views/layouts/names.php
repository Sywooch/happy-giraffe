<?php $this->beginContent('//layouts/baby_no_left_banner');

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

?><div class="right_block">
    <div class="choice_name">
        <h1>Выбор имени <span>ребенка</span></h1>
    </div>
    <ul class="choice_name_navi">
        <li<?php if ($this->action->id == 'index') echo ' class="active"' ?>><a href="<?php
            echo $this->createUrl('/names/default/index') ?>"><ins>По алфавиту</ins></a><span></span></li>
        <li<?php if ($this->action->id == 'top10') echo ' class="active"' ?>><a href="<?php
            echo $this->createUrl('/names/default/top10', array()) ?>"><ins>ТОП-10</ins></a><span></span></li>
        <li<?php if ($this->action->id == 'saint') echo ' class="active"' ?>><a href="<?php
            echo $this->createUrl('/names/default/saint', array()) ?>"><ins>По святцам</ins></a><span></span></li>
        <?php if (!Yii::app()->user->isGuest):?>
            <li class="like<?php if ($this->action->id == 'likes') echo ' active' ?>"><a href="<?php
            echo $this->createUrl('/names/default/likes', array()) ?>"><ins>Нравятся<?php
                echo ' (<ins>'.Yii::app()->controller->likes.'</ins>)' ?></ins></a><span></span></li>
        <?php endif ?>
    </ul>
</div>
<?php echo $content; ?>

<?php $this->endContent(); ?>