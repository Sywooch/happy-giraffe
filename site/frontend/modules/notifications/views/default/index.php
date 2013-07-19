<?php
/**
 * @var $list Notification[] список уведомлений для вывода
 */
$basePath = Yii::getPathOfAlias('application.modules.notifications.views.default.assets');
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/notifcations.js', CClientScript::POS_HEAD);
?>
<div class="user-notice clearfix">
    <div class="user-notice_t-hold clearfix">
        <div class="cont-nav">
            <div class="cont-nav_i active">
                <a href="/notifications/" class="cont-nav_a">Новые</a>
            </div>
            <div class="cont-nav_i">
                <a href="/notifications/read/" class="cont-nav_a">Прочитанные</a>
            </div>
        </div>
        <a href="javascript:;" class="user-notice_mark-all btn-blue" onclick="UserNotification.readAll();">Отметить все как прочитанные</a>
    </div>

    <div class="user-notice-list">

        <?php $this->renderPartial('list', array('list' => $list, 'check' => true)); ?>

        <?php if (count($list) >= 20): ?>
            <div id="infscr-loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif">

                <div>Загрузка ранних уведомлений</div>
            </div>
        <?php endif ?>

    </div>
</div>