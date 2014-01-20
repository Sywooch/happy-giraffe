<?php
/**
 * @var HActiveController $this
 * @var CActiveDataProvider $dp
 * @var int $status
 * @var int[] $counts
 */
?>

<div class="page-col">
    <div class="page-col_top clearfix">
        <div class="page-col_update"><a href="javascript:void(0)" onclick="document.location.reload()" class="textdec-none">
                <div class="ico-update"></div>
                <div class="a-pseudo verticalalign-el">Обновить</div></a>
        </div>
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'htmlOptions' => array(
                'class' => 'page-col_ul',
            ),
            'items' => array(
                array(
                    'url' => array('/antispam/default/list', 'status' => $status, 'entity' => AntispamCheck::ENTITY_POSTS),
                    'label' => 'Посты ' . $counts[AntispamCheck::ENTITY_POSTS],
                    'itemOptions' => array('class' => 'page-col_li'),
                    'linkOptions' => array('class' => 'page-col_ul-a'),
                ),
                array(
                    'url' => array('/antispam/default/list', 'status' => $status, 'entity' => AntispamCheck::ENTITY_COMMENTS),
                    'label' => 'Комментарии ' . $counts[AntispamCheck::ENTITY_COMMENTS],
                    'itemOptions' => array('class' => 'page-col_li'),
                    'linkOptions' => array('class' => 'page-col_ul-a'),
                ),
                array(
                    'url' => array('/antispam/default/list', 'status' => $status, 'entity' => AntispamCheck::ENTITY_PHOTOS),
                    'label' => 'Фото ' . $counts[AntispamCheck::ENTITY_PHOTOS],
                    'itemOptions' => array('class' => 'page-col_li'),
                    'linkOptions' => array('class' => 'page-col_ul-a'),
                ),
            ),
        ));
        ?>
    </div>
    <div class="page-col_cont page-col_cont__gray">
        <!-- antispam-->
        <div class="antispam">
            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dp,
                'itemView' => '_check',
                'summaryText' => '',
                'cssFile' => false,
                'ajaxUpdate' => false,
                'pager' => array(
                    'class' => 'HLinkPager',
                ),
                'template' => '{items}<div class="yiipagination">{pager}</div>',
            ));
            ?>
            <!-- antispam_i-->
        </div>
        <!-- /antispam-->
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('a:not([href*="/antispam"])').attr('target', '_blank');
    });
</script>