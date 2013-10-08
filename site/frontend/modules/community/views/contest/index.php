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
                <div class="heading-small textalign-c margin-b10">Участники <span class="color-gray">(<?=$contest->contestWorksCount?>)</span> </div>
            </div>
            <?php $lastParticipants = $contest->getLastParticipants(10); if ($lastParticipants): ?>
            <ul class="readers2_ul clearfix">
                <?php foreach ($lastParticipants as $contestWork): ?>
                    <li class="readers2_li clearfix">
                        <?php $this->widget('Avatar', array('user' => $contestWork->content->author, 'size' => Avatar::SIZE_MICRO)); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <a class="btn-green btn-medium readers2_btn-inline" href="<?=$contest->getParticipateUrl()?>" class="fancy">Принять участие!</a>
        </div>

        <div class="contest-aside-prizes">
            <div class="contest-aside-prizes_t">Призы конкурса</div>
            <ul class="contest-aside-prizes_ul">
                <li class="contest-aside-prizes_li">
                    <div class="contest-aside-prizes_img">
                        <a href="#popup-contest-prize" class="fancy"><img src="/images/contest/club/pets1/prize-1.jpg" alt=""></a>
                    </div>
                    <div class="place place-1-1"></div>
                    <div class="contest-aside-prizes_name">
                        Лежак-домик «Hilla»
                        <strong>Trixie</strong>
                    </div>
                    <a href="#popup-contest-prize" class="contest-aside-prizes_more fancy">Подробнее</a>
                </li>
                <li class="contest-aside-prizes_li">
                    <div class="contest-aside-prizes_img">
                        <a href="#popup-contest-prize" class="fancy"><img src="/images/contest/club/pets1/prize-2.jpg" alt=""></a>
                    </div>
                    <div class="place place-2-3"></div>
                    <div class="contest-aside-prizes_name">
                        Автоматическая поилка фонтан «Original»
                        <strong>Drinkwell</strong>
                    </div>
                    <a href="#popup-contest-prize" class="contest-aside-prizes_more fancy">Подробнее</a>
                </li>
            </ul>
        </div>

        <?php $topParticipants = $contest->getTopParticipants(3); if ($topParticipants): ?>
        <div class="fast-articles2 js-fast-articles2">
            <div class="fast-articles2_t-ico"></div>
            <?php foreach ($topParticipants as $contestWork): ?>
                <?php $this->renderPartial('application.modules.blog.views.default._popular_one', array('b' => $contestWork->content)); ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
    <div class="col-23-middle ">
        <div class="col-gray">

            <div class="clearfix">
                <div class="float-r margin-t20 margin-r20">
                    <div class="chzn-itx-simple chzn-itx-simple__small">
                        <?=CHtml::dropDownList('sort', $sort, array(
                            '0' => 'По дате добавления',
                            '1' => 'По количеству голосов',
                        ), array(
                            'class' => 'chzn',
                            'onchange' => 'document.location.href = \'' . $this->createUrl('/community/contest/index', array('contestId' => $contest->id)) . '?sort=\' + $(this).val();',
                        ))?>
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
<?php $this->renderPartial('_prizes', compact('contest')); ?>
</div>