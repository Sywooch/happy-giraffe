<?php $this->beginContent('//layouts/community');

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript
    ->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
?>
<div class="col-white padding-20 clearfix">
    <div id="baby">
        <div class="content-box clearfix">

            <div class="right_block">
                <div class="choice_name">
                    <div class="title-in">Выбор имени <span>ребенка</span></div>
                </div>
                <ul class="choice_name_navi">
                    <li<?php if ($this->action->id == 'index') echo ' class="active"' ?>><a href="<?php
                        echo $this->createUrl('index') ?>"><ins>По алфавиту</ins></a><span></span></li>
                    <li<?php if ($this->action->id == 'top10') echo ' class="active"' ?>><a href="<?php
                        echo $this->createUrl('top10', array()) ?>"><ins>ТОП-10</ins></a><span></span></li>
                    <li<?php if ($this->action->id == 'saint') echo ' class="active"' ?>><a href="<?php
                        echo $this->createUrl('saint', array()) ?>"><ins>По святцам</ins></a><span></span></li>
                    <?php if (!Yii::app()->user->isGuest):?>
                        <li class="like<?php if ($this->action->id == 'likes') echo ' active' ?>"><a href="<?php
                        echo $this->createUrl('likes', array()) ?>"><ins>Нравятся<?php
                            echo ' (<ins>'.Yii::app()->controller->likes.'</ins>)' ?></ins></a><span></span></li>
                    <?php endif ?>
                </ul>
            </div>

            <?php echo $content; ?>

        </div>
    </div>
</div>

<?php $this->endContent(); ?>