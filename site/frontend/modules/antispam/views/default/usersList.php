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
    </div>
    <!-- /antispam-->
    </div>
</div>