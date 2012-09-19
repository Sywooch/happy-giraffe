<div id="user-notifications" class="clearfix">

    <div class="header">

        <div class="title">
            <span>Уведомления</span>
        </div>

        <a href="javascript:void(0)" onclick="Notifications.close()" class="close">Закрыть уведомления</a>

    </div>

    <div class="notifications">

        <?php
            $this->widget('zii.widgets.CListView', array(
                'id' => 'notificationsList',
                'dataProvider' => $dp,
                'itemView' => '_notification',
                'itemsTagName' => 'ul',
                'template' => '{items} {pager}',
                'pager' => array(
                    'class' => 'ext.infiniteScroll.IasPager',
                    'rowSelector' => 'li',
                    'listViewId' => 'notificationsList',
                    'options' => array(
                        'scrollContainer' => new CJavaScriptExpression('$(\'#notificationsList .items\')'),
                    ),
                ),
            ));
        ?>

    </div>

</div>