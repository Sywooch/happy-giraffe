<?php
/**
 * @var CActiveDataProvider $dp
 * @var User[] $onlineUsers
 */
?>
<div class="content-cols clearfix">
    <div class="col-1">

        <div class="readers2 readers2__no-btn readers2__m">
            <div class="readers2_t-sm heading-small">
                <span class="icon-status icon-status__small icon-status__status-online"></span>
                Сейчас на сайте <?php /*count($onlineUsers)*/  ?>
            </div>
            <ul class="readers2_ul clearfix">
                <?php foreach ($onlineUsers as $user): ?>
                    <li class="readers2_li clearfix">
                        <?php $this->widget('Avatar', array('user' => $user, 'size' => 40)); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="readers2_sub-tx">и еще много <span class="readers2_smile"></span>!!!</div>
        </div>

    </div>
    <div class="col-23-middle ">

        <?php
            $this->widget('zii.widgets.CListView', array(
                'cssFile' => false,
                'ajaxUpdate' => false,
                'dataProvider' => $dp,
                'itemView' => 'site.frontend.modules.blog.views.default.view',
                'pager' => array(
                    'class' => 'HLinkPager',
                ),
                'template' => '{items}
                    <div class="yiipagination">
                        {pager}
                    </div>
                ',
                'emptyText' => '',
                'viewData' => array('full' => false),
            ));
        ?>

    </div>
</div>