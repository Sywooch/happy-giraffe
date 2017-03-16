<?php
$this->beginContent('//layouts/lite/main');
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
            <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adfox')); ?>
            <div class="bnr-base">
                <div id="adfox_1488276558162881"></div>
                <script type="text/javascript">
                    require(['AdFox'], function() {
                        window.Ya.adfoxCode.create({
                            ownerId: 211012,
                            containerId: 'adfox_1488276558162881',
                            params: {
                                pp: 'dey',
                                ps: 'bkqy',
                                p2: 'etcx'
                            }
                        });
                    });
                </script>
            </div>
            <?php $this->endWidget(); ?>

            <div class="side-block rubrics">
                <div class="side-block_tx">Темы новостей</div>
                <ul>
                    <li class="rubrics_li"><a class="rubrics_a" href="<?=$this->createUrl('/som/community/news/index')?>">Все</a>
                        <div class="rubrics_count"><span class="rubrics_count_tx"><?=\site\frontend\modules\community\helpers\StatsHelper::getByLabels(array(\site\frontend\modules\posts\models\Label::LABEL_NEWS))?></span></div>
                    </li>
                    <?php foreach (CommunityClub::model()->findAll() as $club): ?>
                        <?php $count = \site\frontend\modules\community\helpers\StatsHelper::countCommentNewsTopicByLabels(array($club->toLabel(), \site\frontend\modules\posts\models\Label::LABEL_NEWS), true); ?>
                        <?php if ($count > 0): ?>
                        <li class="rubrics_li"><a class="rubrics_a" href="<?=$this->createUrl('/som/community/news/index', array('slug' => $club->slug))?>"><?=$club->title?></a>
                            <div class="rubrics_count"><span class="rubrics_count_tx"><?=$count?></span></div>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>
</div>
<?php
$this->endContent();
