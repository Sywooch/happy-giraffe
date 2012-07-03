<?php
/* @var $this CController
 * @var $models UserSignal[]
 * @var $history UserSignal[]
 */

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

$js = "
        comet.addEvent(".CometModel::TYPE_SIGNAL_UPDATE.", 'UpdateTable');
        comet.addEvent(".CometModel::TYPE_SIGNAL_EXECUTED.", 'TaskExecuted');

        Signal.year = ". date('Y') .";
        Signal.month = ". date('n') .";
        Signal.current_date = '". date("Y-m-d")  ."';";

$cs = Yii::app()->clientScript;
$cs
    ->registerScriptFile('/javascripts/soundmanager2.js', CClientScript::POS_HEAD)
    ->registerScriptFile('/javascripts/comet.js')
    ->registerScriptFile($baseUrl . '/signal.js?r=1', CClientScript::POS_HEAD)
    ->registerScript('SignalInit2', $js);

?>
<div class="fast-calendar">
    <?php $this->renderPartial('_calendar', array(
    'month' => date("n"),
    'year' => date("Y"),
    'activeDate' => date("Y-m-d"),
)); ?>
</div>
<div class="title"><i class="icon"></i>Сигналы</div>

<div class="username">
    <i class="icon-status status-online"></i><span><?php echo CHtml::encode(Yii::app()->user->model->fullName); ?></span>
</div>

<div class="nav">
    <ul>
        <li class="active"><a href="" obj="">Все</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_POST ?>">Посты</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_VIDEO ?>">Видео</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_BLOG_POST ?>">Блоги</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_PHOTO ?>">Фото</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_REGISTER ?>">Гостевые</a></li>
    </ul>
</div>

<div class="clear"></div>
<input type="checkbox" id="play_sound" checked/> <label for="play_sound">Проигрывать звук</label>
<?php if (Yii::app()->user->id == 10): ?>
<br><a href="#" onclick="Signal.removeHistory();">Очистить всё</a>
<?php endif ?>
<a href="#" onclick="Signal.Play('yes');return false;" style="display: none;">Play</a>
<div class="main-list">
    <?php $this->renderPartial('_data', array('models' => $models)); ?>
</div>

<div class="fast-list">
    <?php $this->renderPartial('_history', array('history' => $history)); ?>
</div>