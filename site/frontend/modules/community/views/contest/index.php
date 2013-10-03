<?php
/**
 * @var CommunityContest $contest
 */

Yii::app()->clientScript->registerPackage('ko_community');
?>

<?php $this->renderPartial('_header', compact('contest')); ?>

<div class="content-cols clearfix">
    <div class="col-1">

        <div class="readers2 margin-t0">
            <div class="clearfix">
                <div class="heading-small textalign-c margin-b10">Участники <span class="color-gray">(156)</span> </div>
            </div>
            <ul class="readers2_ul clearfix">
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava male small" href="">
                        <span class="icon-status status-online"></span>
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava female small" href="">
                        <span class="icon-status status-online"></span>
                        <img src="http://img.happy-giraffe.ru/avatars/34531/small/2fd2c2d5e773c3cb8a36ce231fbc6ce0.JPG" alt="">
                    </a>
                </li>
                <li class="readers2_li clearfix">
                    <a class="ava male small" href="">
                        <span class="icon-status status-online"></span>
                    </a>
                </li>
            </ul>
            <a class="btn-green btn-medium readers2_btn-inline" href="<?=$contest->getParticipateUrl()?>" class="fancy">Принять участие!</a>
        </div>

        <div class="contest-aside-prizes">
            <div class="contest-aside-prizes_t">Призы конкурса</div>
            <ul class="contest-aside-prizes_ul">
                <li class="contest-aside-prizes_li">
                    <div class="contest-aside-prizes_img">
                        <img src="/images/contest/club/pets1/prize-1.jpg" alt="">
                    </div>
                    <div class="place place-1-1"></div>
                    <div class="contest-aside-prizes_name">
                        Рацион для щенков<br>
                        <strong>«Pedigree»</strong>
                    </div>
                </li>
                <li class="contest-aside-prizes_li">
                    <div class="contest-aside-prizes_img">
                        <img src="/images/contest/club/pets1/prize-2.jpg" alt="">
                    </div>
                    <div class="place place-2"></div>
                    <div class="contest-aside-prizes_name">
                        Рацион для кошек<br>
                        <strong>«Whiskas»</strong>
                    </div>
                </li>
                <li class="contest-aside-prizes_li">
                    <div class="contest-aside-prizes_img">
                        <img src="/images/contest/club/pets1/prize-3.jpg" alt="">
                    </div>
                    <div class="place place-3"></div>
                    <div class="contest-aside-prizes_name">
                        Средства по уходу за животными<br>
                        <strong>«C-Airlaid ZOO»</strong>
                    </div>
                </li>
            </ul>
        </div>


        <div class="fast-articles2 js-fast-articles2">
            <div class="fast-articles2_t-ico"></div>
            <div class="fast-articles2_i">
                <div class="fast-articles2_header clearfix">

                    <div class="meta-gray">
                        <a href="" class="meta-gray_comment">
                            <span class="ico-comment ico-comment__gray"></span>
                            <span class="meta-gray_tx">35</span>
                        </a>
                        <div class="meta-gray_view">
                            <span class="ico-view ico-view__gray"></span>
                            <span class="meta-gray_tx">305</span>
                        </div>
                    </div>

                    <div class="float-l">
                        <span class="font-smallest color-gray">Сегодня 13:25</span>
                    </div>
                </div>
                <div class="fast-articles2_i-t">
                    <a href="" class="fast-articles2_i-t-a"> О моем первом бойфренде</a>
                </div>
                <div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала </div>
                <div class="fast-articles2_i-img-hold">
                    <a href=""><img src="/images/example/w190-h166.jpg" alt="" class="fast-articles2_i-img"></a>
                </div>
            </div>
            <div class="fast-articles2_i">
                <div class="fast-articles2_header clearfix">

                    <div class="meta-gray">
                        <a href="" class="meta-gray_comment">
                            <span class="ico-comment ico-comment__gray"></span>
                            <span class="meta-gray_tx">35</span>
                        </a>
                        <div class="meta-gray_view">
                            <span class="ico-view ico-view__gray"></span>
                            <span class="meta-gray_tx">305</span>
                        </div>
                    </div>

                    <div class="float-l">
                        <span class="font-smallest color-gray">Сегодня 13:25</span>
                    </div>
                </div>
                <div class="fast-articles2_i-t">
                    <a href="" class="fast-articles2_i-t-a"> Как мне предлагали руку и сердце</a>
                </div>
                <div class="fast-articles2_i-desc">Практически нет девушки, которая не переживала </div>
                <div class="fast-articles2_i-img-hold">
                    <a href=""><img src="/images/example/w190-h166.jpg" alt="" class="fast-articles2_i-img"></a>
                </div>
            </div>
        </div>

    </div>
    <div class="col-23-middle ">
        <div class="col-gray">

            <div class="clearfix">
                <div class="float-r margin-t20 margin-r20">
                    <div class="chzn-itx-simple chzn-itx-simple__small">
                        <select name="" id="" class="chzn">
                            <!-- список option не точный -->
                            <option value="">По дате добавления</option>
                            <option value="">По количеству голосов</option>
                        </select>
                    </div>

                </div>
            </div>


            <?php $this->widget('zii.widgets.CListView', array(
                'cssFile' => false,
                'ajaxUpdate' => false,
                'dataProvider' => $works,
                'itemView' => 'view',
                'pager' => array(
                    'class' => 'HLinkPager',
                ),
                'template' => '{items}
                    <div class="yiipagination">
                        {pager}
                    </div>
                ',
                'emptyText' => '',
                'viewData' => array('full' => false, 'isContestWork' => true),
            ));
            ?>

            </div>
    </div>
</div>

<div class="display-n">
<?php $this->renderPartial('_rules', compact('contest')); ?>
</div>