<?php
$this->pageTitle = 'Мой Жираф';
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <aside class="b-main_col-sidebar visible-md">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Все', 'url' => Yii::app()->createUrl('myGiraffe/post/index', array('type' => NewSubscribeDataProvider::TYPE_ALL))),
                    array('label' => 'Друзья', 'url' => Yii::app()->createUrl('myGiraffe/post/index', array('type' => NewSubscribeDataProvider::TYPE_FRIENDS))),
                    array('label' => 'Подписки', 'url' => Yii::app()->createUrl('myGiraffe/post/index', array('type' => NewSubscribeDataProvider::TYPE_BLOGS))),
                    array('label' => 'Клубы', 'url' => Yii::app()->createUrl('myGiraffe/post/index', array('type' => NewSubscribeDataProvider::TYPE_COMMUNITY))),
                ),
            ));
            ?>
        </aside>
        <?php
        $this->widget('LiteListView', array(
            'dataProvider' => $this->listDataProvider,
            'itemView' => 'site.frontend.modules.posts.views.list._view',
            'tagName' => 'div',
            'htmlOptions' => array(
                'class' => 'b-main_col-article'
            ),
            'itemsTagName' => 'div',
            'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
        ));
        ?>
    </div>
</div>