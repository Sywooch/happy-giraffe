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
        <h1 class="user-notice_t">Уведомления</h1>

        <div class="cont-nav">
            <div class="cont-nav_i">
                <a href="/notifications/" class="cont-nav_a">Новые</a>
            </div>
            <div class="cont-nav_i active">
                <a href="/notifications/read/" class="cont-nav_a">Прочитанные</a>
            </div>
        </div>
    </div>

    <div class="user-notice_desc">Уведомления, хранящиеся более 10 дней, удаляются автоматически.</div>

    <div class="user-notice-list">
        <div id="user-notice-list_inner">
            <?php $this->renderPartial('list', array('list' => $list, 'check' => false)); ?>
        </div>

        <?php if (count($list) >= 20):?>
            <div id="infscr-loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif">
                <div>Загрузка ранних уведомлений</div>
            </div>
        <?php endif ?>
    </div>
</div>
