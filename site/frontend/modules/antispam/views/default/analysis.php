<?php
/**
 * @var HController $this
 * @var User $user
 * @var CActiveDataProvider $dp
 */
?>
<div class="page-col">
    <div class="page-col_top clearfix">
        <div class="antispam-user">
            <div class="float-r margin-t15"><a href="" class="textdec-none">
                    <div class="ico-check"></div>
                    <div class="a-pseudo display-ib">Все хорошо</div></a></div>
            <div class="antispam-user_hold">
                <?php $this->widget('UserInfoWidget', array('user' => $user)); ?>
                <?php $this->widget('UserMarkWidget', array('status' => $user->spamStatus, 'extended' => false)); ?>
            </div>
        </div>
    </div>
    <div class="page-col_cont page-col_cont__gray">
        <!-- antispam-->
        <div class="antispam">
            <div class="page-col_top">
                <ul class="page-col_ul">
                    <li class="page-col_li active"><a href="" class="page-col_ul-a">Записи 54</a></li>
                    <li class="page-col_li"><a href="" class="page-col_ul-a">Комментарии 165</a></li>
                    <li class="page-col_li"><a href="" class="page-col_ul-a">Фотографии 65</a></li>
                    <li class="page-col_li disabled"><a href="" class="page-col_ul-a">Сообщения 65</a></li>
                </ul>
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