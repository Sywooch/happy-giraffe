<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Name
 */

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
$m =(empty($month))?'null':$month;
$script = 'month = '. $m .';';
Yii::app()->clientScript
    ->registerScript('names-saint-month', $script, CClientScript::POS_READY)
    ->registerScriptFile($baseUrl . '/saint.js', CClientScript::POS_HEAD)
;

?><ul class="letters month">
    <li<?php if ($month == 1) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'january')) ?>">Январь</a></li>
    <li<?php if ($month == 2) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'february')) ?>">Февраль</a></li>
    <li<?php if ($month == 3) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'march')) ?>">Март</a></li>
    <li<?php if ($month == 4) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'april')) ?>">Апрель</a></li>
    <li<?php if ($month == 5) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'may')) ?>">Май</a></li>
    <li<?php if ($month == 6) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'june')) ?>">Июнь</a></li>
    <li<?php if ($month == 7) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'july')) ?>">Июль</a></li>
    <li<?php if ($month == 8) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'august')) ?>">Август</a></li>
    <li<?php if ($month == 9) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'september')) ?>">Сентябрь</a></li>
    <li<?php if ($month == 10) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'october')) ?>">Октябрь</a></li>
    <li<?php if ($month == 11) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'november')) ?>">Ноябрь</a></li>
    <li<?php if ($month == 12) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('saint', array('month'=>'december')) ?>">Декабрь</a></li>
</ul>

<div class="content_block">
    <?php $this->renderPartial('_gender'); ?>
    <p class="names_header calendar">Имена по святцам<?php if (!empty($month)) echo ' - <span>' . HDate::ruMonth($month). '</span>'; ?></p>
    <div class="clear"></div>

    <div id="result">
        <?php if ($month !== null):?>
        <?php $this->renderPartial('saint_res',array(
            'month'=>$month,
            'data' => $data,
            'like_ids' => $like_ids
        )); ?>
        <?php endif ?>
    </div>
</div>