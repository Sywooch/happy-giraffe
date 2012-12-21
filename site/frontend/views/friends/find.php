<?php
    $js = '
            var $container = $("#friendsList .items");

            $container.imagesLoaded(function() {
                $container.isotope({
                    itemSelector : ".masonry-news-list_item"
                });
            });
        ';

    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerCssFile('/stylesheets/isotope.css')
        ->registerScriptFile('/javascripts/jquery.isotope.min.js')
        ->registerScript('findFriends-isotope', $js)
    ;
?>

<div class="find-friend-page">
    <div class="find-friend-title clearfix">
        <div class="search-box">
            <div class="search-box_input">
                <?=CHtml::beginForm('/findFriends/', 'get')?>
                    <?=CHtml::textField('query', Yii::app()->request->getParam('query'), array('class' => 'text', 'placeholder' => 'Введите имя'))?>
                    <button class="icon-search"></button>
                <?=CHtml::endForm()?>
            </div>
        </div>
        <h1><i class="icon-find-friend"></i> Найти друзей</h1>
        <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'Сейчас на сайте',
                        'url' => array('friends/find', 'type' => FindFriendsManager::BY_ONLINE),
                        'itemOptions' => array(
                            'class' => 'green',
                        ),
                    ),
                    array(
                        'label' => 'Из моего региона',
                        'url' => array('friends/find', 'type' => FindFriendsManager::BY_REGION),
                        'visible' => Yii::app()->user->model->address->region !== null && Yii::app()->user->model->address->region->usersCount >= 50,
                    ),
                    array(
                        'label' => 'С похожими интересами',
                        'url' => array('friends/find', 'type' => FindFriendsManager::BY_INTERESTS),
                        'visible' => ! empty(Yii::app()->user->model->interests),
                    ),
                    array(
                        'label' => 'С похожим статусом',
                        'url' => array('friends/find', 'type' => FindFriendsManager::BY_STATUS),
                        'visible' => false,
                    ),
                ),
                'htmlOptions' => array(
                    'class' => 'find-friend-menu',
                ),
            ));
        ?>
    </div>

    <?php
        $this->widget('zii.widgets.CListView', array(
            'id' => 'friendsList',
            'dataProvider' => $dp,
            'itemView' => '_friend',
            'template' => "{items}\n{pager}",
            'itemsTagName' => 'ul',
            'htmlOptions' => array(
                'class' => 'masonry-news-list',
            ),
            'viewData' => array(
                'type' => $type,
            ),
            'pager' => array(
                'header' => '',
                'class' => 'ext.infiniteScroll.IasPager',
                'rowSelector' => '.masonry-news-list_item',
                'listViewId' => 'friendsList',
                'options' => array(
                    'scrollContainer' => new CJavaScriptExpression("$('.layout-container')"),
                    'tresholdMargin' => -250,
                    'onRenderComplete' => new CJavaScriptExpression("function(items) {
                        var newItems = $(items);

                        newItems.hide().imagesLoaded(function() {
                            newItems.show();
                            $('#friendsList .items').isotope('appended', newItems);
                        });
                    }"),
                ),
            ),
        ));
    ?>

</div>