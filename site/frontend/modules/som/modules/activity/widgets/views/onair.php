<div class="homepage_row">
    <div class="homepage-onair">
        <div id="buttons">
            <div class="homepage_title">Прямой эфир<div class="homepage-onair_load" data-bind="visible: loading"></div></div>
            <div class="homepage-onair_arrows clearfix">
                <a class="homepage-onair_arrows_arrow homepage-onair_arrows_left" data-bind="click: prev, css: { 'inactive': prevActive() === false }"></a>
                <a class="homepage-onair_arrows_arrow homepage-onair_arrows_right" data-bind="click: next, css: { 'inactive': nextActive() === false }"></a>
            </div>
        </div>

        <div class="homepage-onair_activity" id="homepage-onair">
            <?php
            $this->widget('LiteListView', array(
                'dataProvider' => $this->getDataProvider(),
                'itemView' => 'site.frontend.modules.som.modules.activity.widgets.views._view',
                'tagName' => 'div',
                'itemsTagName' => false,
                'template' => '{items}',

            ));
            ?>
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerAMD('messagingVM', array('Activity' => 'homepage-onair/homepage-activity', 'ko' => 'knockout'), "ko.applyBindings(new Activity(), document.getElementById('buttons'));");
?>