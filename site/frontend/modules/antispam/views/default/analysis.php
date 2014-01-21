<?php
/**
 * @var HController $this
 * @var User $user
 * @var CActiveDataProvider $dp
 * @var int $entity
 */
?>
<div class="page-col">
    <div class="page-col_top clearfix">
        <div class="antispam-user">
            <div class="float-r margin-t15"><a href="javascript:void(0)" class="textdec-none" onclick="markGoodAll(<?=$entity?>, <?=$user->id?>)">
                    <div class="ico-check"></div>
                    <div class="a-pseudo display-ib">Все хорошо</div></a></div>
            <div class="antispam-user_hold">
                <?php $this->widget('UserInfoWidget', array('user' => $user)); ?>
                <?php $this->widget('UserMarkWidget', array('user' => $user, 'extended' => false)); ?>
            </div>
        </div>
    </div>
    <div class="page-col_cont page-col_cont__gray">
        <!-- antispam-->
        <div class="antispam">
            <div class="page-col_top">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array(
                        'class' => 'page-col_ul',
                    ),
                    'items' => array(
                        array(
                            'url' => array('/antispam/default/analysis', 'userId' => $user->id, 'entity' => AntispamCheck::ENTITY_POSTS),
                            'label' => 'Посты ' . $counts[AntispamCheck::ENTITY_POSTS],
                            'itemOptions' => array('class' => 'page-col_li'),
                            'linkOptions' => array('class' => 'page-col_ul-a'),
                        ),
                        array(
                            'url' => array('/antispam/default/analysis', 'userId' => $user->id, 'entity' => AntispamCheck::ENTITY_COMMENTS),
                            'label' => 'Комментарии ' . $counts[AntispamCheck::ENTITY_COMMENTS],
                            'itemOptions' => array('class' => 'page-col_li'),
                            'linkOptions' => array('class' => 'page-col_ul-a'),
                        ),
                        array(
                            'url' => array('/antispam/default/analysis', 'userId' => $user->id, 'entity' => AntispamCheck::ENTITY_PHOTOS),
                            'label' => 'Фото ' . $counts[AntispamCheck::ENTITY_PHOTOS],
                            'itemOptions' => array('class' => 'page-col_li'),
                            'linkOptions' => array('class' => 'page-col_ul-a'),
                        ),
                        array(
                            'url' => array('/antispam/default/analysis', 'userId' => $user->id, 'entity' => AntispamCheck::ENTITY_MESSAGES),
                            'label' => 'Фото ' . $counts[AntispamCheck::ENTITY_MESSAGES],
                            'itemOptions' => array('class' => 'page-col_li'),
                            'linkOptions' => array('class' => 'page-col_ul-a'),
                        ),
                    ),
                ));
                ?>
            </div>

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
        </div>
        <!-- /antispam-->
    </div>
</div>