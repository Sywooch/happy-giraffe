<?php
/**
 * @var \site\frontend\modules\posts\modules\onAir\controllers\DefaultController $this
 */
$this->pageTitle = 'Прямой эфир';
?>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php
        $this->widget('site\frontend\modules\posts\modules\onAir\widgets\OnlineUsersWidget');
        ?>

    </div>
    <div class="col-23-middle ">

        <?php
        $this->widget('LiteListView', array(
            'dataProvider' => $this->getListDataProvider(),
            'itemView' => 'posts.views.list._view',
            'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
            'pager' => array(
                'class' => 'LitePager',
                'maxButtonCount' => 10,
                'prevPageLabel' => '&nbsp;',
                'nextPageLabel' => '&nbsp;',
                'showPrevNext' => true,
            ),
        ));
        ?>

    </div>
</div>