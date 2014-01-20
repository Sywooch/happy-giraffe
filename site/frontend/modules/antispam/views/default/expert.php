<?php
/**
 * @var CActiveDataProvider $dp
 */
?>
<div class="page-col">
    <div class="page-col_top">
        <div class="page-col_t">
            <div class="page-col_t-tx">Белый список 256</div>
        </div>
    </div>
    <div class="page-col_cont page-col_cont__gray">
        <!-- antispam-->
        <div class="antispam">
            <div class="antispam-user antispam-user__expert">
                <ul class="antispam-user_ul">
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dp,
                        'itemView' => '_report',
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
        </div>
        <!-- /antispam-->
    </div>
</div>