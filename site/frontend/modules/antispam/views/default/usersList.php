<?php
/**
 * @var CActiveDataProvider $dp
 * @var int $status
 */
?>

<div class="page-col">
    <div class="page-col_top">
        <div class="page-col_t">
            <div class="page-col_t-tx">
                <?php if ($status == AntispamStatusManager::STATUS_WHITE): ?>
                    Белый список <?=$this->counts[DefaultController::TAB_USERS_WHITE]?>
                <?php endif; ?>
                <?php if ($status == AntispamStatusManager::STATUS_BLACK): ?>
                    Черный список <?=$this->counts[DefaultController::TAB_USERS_BLACK]?>
                <?php endif; ?>
                <?php if ($status == AntispamStatusManager::STATUS_BLOCKED): ?>
                    Блок <?=$this->counts[DefaultController::TAB_USERS_BLOCKED]?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="page-col_cont page-col_cont__gray">
    <!-- antispam-->
    <div class="antispam">
        <div class="antispam-user">
            <ul class="antispam-user_ul">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dp,
                    'itemView' => '_user',
                    'summaryText' => '',
                    'cssFile' => false,
                    'ajaxUpdate' => false,
                    'pager' => array(
                        'class' => 'HLinkPager',
                    ),
                    'template' => '{items}<div class="yiipagination">{pager}</div>',
                ));
                ?>
            </ul>
        </div>
        <!-- antispam_i-->
        <?php if (false): ?>
            <div class="antispam_i clearfix">
                <div class="antispam_cont">
                    <!-- paginator-->
                    <div class="yiipagination margin-l100">
                        <div class="pager">
                            <ul class="yiiPager">
                                <li class="page"><a href="">1</a></li>
                                <li class="page"><a href="">2</a></li>
                                <li class="page selected"><a href="">3</a></li>
                                <li class="page"><a href="">4</a></li>
                                <li class="page"><a href="">5</a></li>
                                <li class="page"><a href="">6</a></li>
                                <li class="page"><a href="">7</a></li>
                                <li class="page"><a href="">8</a></li>
                                <li class="page"><a href="">9</a></li>
                                <li class="page"><a href="">10</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /paginator-->
                </div>
                <div class="antispam_control"></div>
            </div>
        <?php endif; ?>
    </div>
    <!-- /antispam-->
    </div>
</div>