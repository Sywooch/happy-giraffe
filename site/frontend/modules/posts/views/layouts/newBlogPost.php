<?php
$this->bodyClass .= ' page-blog';
$this->beginContent('//layouts/lite/main');
?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
            <?php if (false): ?>
            <?php $this->beginWidget('AdsWidget', array('dummyTag' => 'adfox')); ?>
            <!--AdFox START-->
            <!--giraffe-->
            <!--Площадка: Весёлый Жираф / * / *-->
            <!--Тип баннера: Тексто-графические-->
            <!--Расположение: &lt;сайдбар&gt;-->
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
                document.write('<scr' + 'ipt type="text/javascript" src="//ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=exim&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr + '&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                // -->
            </script>
            <?php $this->endWidget(); ?>
            <?php endif; ?>

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
