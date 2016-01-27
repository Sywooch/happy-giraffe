<?php
$this->bodyClass .= ' page-community';
$this->beginContent('//layouts/lite/community');
?>
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <?php
            echo $content;
            ?>
            <aside class="b-main_col-sidebar visible-md">
                <?php if ($this->club): ?>
                <community-add params="forumId: <?= $this->forum->id ?>, clubSubscription: <?= CJSON::encode(UserClubSubscription::subscribed(Yii::app()->user->id, $this->club->id)) ?>, clubId: <?= $this->club->id ?>, subsCount: <?= (int)UserClubSubscription::model()->getSubscribersCount($this->club->id) ?>"></community-add>
                <?php endif; ?>

                <?php if (false): ?>
                    <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adfox')); ?>
                    <!--AdFox START-->
                    <!--giraffe-->
                    <!--Площадка: Весёлый Жираф / * / *-->
                    <!--Тип баннера: Тексто-графические-->
                    <!--Расположение: &lt;сайдбар&gt;-->
                    <script type="text/javascript">
                        <!--
                        if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 1000000); }
                        if (typeof(document.referrer) != 'undefined') {
                            if (typeof(afReferrer) == 'undefined') {
                                afReferrer = escape(document.referrer);
                            }
                        } else {
                            afReferrer = '';
                        }
                        var addate = new Date();
                        var scrheight = '', scrwidth = '';
                        if (self.screen) {
                            scrwidth = screen.width;
                            scrheight = screen.height;
                        } else if (self.java) {
                            var jkit = java.awt.Toolkit.getDefaultToolkit();
                            var scrsize = jkit.getScreenSize();
                            scrwidth = scrsize.width;
                            scrheight = scrsize.height;
                        }
                        document.write('<scr' + 'ipt type="text/javascript" src="//ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=exim&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                        // -->
                    </script>
                    <?php $this->endWidget(); ?>
                <?php endif; ?>

                <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adfox')); ?>
                <div class="bnr-base">
                    <!--AdFox START-->
                    <!--giraffe-->
                    <!--Площадка: Весёлый Жираф / * / *-->
                    <!--Тип баннера: Безразмерный 240x400-->
                    <!--Расположение: &lt;сайдбар&gt;-->
                    <script type="text/javascript">
                        <!--
                        if (typeof(pr) == 'undefined') { var pr = Math.floor(Math.random() * 4294967295) + 1; }
                        if (typeof(document.referrer) != 'undefined') {
                            if (typeof(afReferrer) == 'undefined') {
                                afReferrer = escape(document.referrer);
                            }
                        } else {
                            afReferrer = '';
                        }
                        var addate = new Date();
                        var scrheight = '', scrwidth = '';
                        if (self.screen) {
                            scrwidth = screen.width;
                            scrheight = screen.height;
                        } else if (self.java) {
                            var jkit = java.awt.Toolkit.getDefaultToolkit();
                            var scrsize = jkit.getScreenSize();
                            scrwidth = scrsize.width;
                            scrheight = scrsize.height;
                        }
                        document.write('<scr' + 'ipt type="text/javascript" src="//ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                        // -->
                    </script>
                    <!--AdFox END-->
                </div>
                <?php $this->endWidget(); ?>

                <? if ($this instanceof site\frontend\modules\posts\controllers\PostController && $this->post->templateObject->getAttr('hideRubrics', false)): ?>
                    <div class="side-block onair-min">
                        <div class="side-block_tx">Прямой эфир</div>

                        <?php
                        $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
                            'pageVar' => 'page',
                            'view' => 'onair-min',
                            'pageSize' => 5,
                        ));
                        ?>
                    </div>

                    <? if (! ($this instanceof site\frontend\modules\posts\controllers\PostController) || ($this->post->isNoindex == 0 && ! $this->post->templateObject->getAttr('hideAdsense', false))): ?>
                        <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adsense')); ?>
                        <div class="bnr-base">
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- ÕÂ·ÓÒÍÂ· new -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:300px;height:600px"
                                 data-ad-client="ca-pub-3807022659655617"
                                 data-ad-slot="5201434880"></ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                            <?php $this->endWidget(); ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <? if (! ($this instanceof site\frontend\modules\posts\controllers\PostController) || (! $this->post->templateObject->getAttr('hideRubrics', false))): ?>
                        <div class="side-block rubrics">
                            <div class="side-block_tx">Рубрики клуба</div>
                            <ul>
                                <?php foreach ($this->forum->rubrics as $rubric): ?>
                                    <?php if ($rubric->parent_id === null): ?>
                                        <li class="rubrics_li"><a class="rubrics_a" href="<?=$rubric->getUrl()?>"><?=$rubric->title?></a>
                                            <div class="rubrics_count"><span class="rubrics_count_tx"><?=\site\frontend\modules\community\helpers\StatsHelper::getRubricCount($rubric->id)?></span></div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <? if (! ($this instanceof site\frontend\modules\posts\controllers\PostController) || ($this->post->isNoindex == 0 && ! $this->post->templateObject->getAttr('hideAdsense', false))): ?>
                        <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adsense')); ?>
                        <div class="bnr-base">
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- ÕÂ·ÓÒÍÂ· new -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:300px;height:600px"
                                 data-ad-client="ca-pub-3807022659655617"
                                 data-ad-slot="5201434880"></ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                            <?php $this->endWidget(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="side-block onair-min">
                        <div class="side-block_tx">Прямой эфир</div>

                        <?php
                        $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
                            'pageVar' => 'page',
                            'view' => 'onair-min',
                            'pageSize' => 5,
                        ));
                        ?>
                    </div>

                    <? if (! ($this instanceof site\frontend\modules\posts\controllers\PostController) || ($this->post->isNoindex == 0 && ! $this->post->templateObject->getAttr('hideAdsense', false))): ?>
                        <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adsense')); ?>
                        <div class="bnr-base">
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- 300 -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:300px;height:250px"
                                 data-ad-client="ca-pub-3807022659655617"
                                 data-ad-slot="8256939681"></ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>
                        <?php $this->endWidget(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </aside>
        </div>
    </div>

<?php if (Yii::app()->vm->getVersion() == VersionManager::VERSION_DESKTOP): ?>
    <div class="homepage">
        <div class="homepage_row">
            <div class="homepage-posts">
                <div class="homepage_title">еще рекомендуем</div>
                <div class="homepage-posts_col-hold">

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
$this->endContent();
