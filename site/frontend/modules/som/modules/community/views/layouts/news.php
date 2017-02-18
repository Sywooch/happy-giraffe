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
                <!--AdFox START-->
                <!--giraffe-->
                <!--Площадка: Весёлый Жираф / * / *-->
                <!--Тип баннера: Безразмерный 240x400-->
                <!--Расположение: &lt;сайдбар&gt;-->
                <!-- ________________________AdFox Asynchronous code START__________________________ -->
                <script type="text/javascript">
                    <!--
                    if (typeof (pr) == 'undefined') {
                        var pr = Math.floor(Math.random() * 1000000);
                    }
                    if (typeof (document.referrer) != 'undefined') {
                        if (typeof (afReferrer) == 'undefined') {
                            afReferrer = escape(document.referrer);
                        }
                    } else {
                        afReferrer = '';
                    }
                    var addate = new Date();


                    var dl = escape(document.location);
                    var pr1 = Math.floor(Math.random() * 1000000);

                    document.write('<div id="AdFox_banner_' + pr1 + '"><\/div>');
                    document.write('<div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_' + pr1 + '" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>');

                    AdFox_getCodeScript(1, pr1, 'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr + '&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl=' + dl + '&amp;pr1=' + pr1);
                    // -->
                </script>
                <!-- _________________________AdFox Asynchronous code END___________________________ -->
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
