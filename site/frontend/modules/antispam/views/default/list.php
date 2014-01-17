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
            ));
            ?>
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