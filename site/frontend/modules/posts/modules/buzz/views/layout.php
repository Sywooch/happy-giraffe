<?php
/**
 * @var site\frontend\modules\posts\modules\buzz\controllers\DefaultController $this
 * @var string $content
 */
$this->beginContent('//layouts/lite/main');
?>
  	<div class="homepage__title_comment-wrapper">
    	<div class="homepage__title_buzz">Жизнь</div>
  	</div>

    <div class="b-main_cont b-main_cont-xs">
        <div class="b-main_col-hold clearfix">
            <?php
            echo $content;
            ?>
            <aside class="b-main_col-sidebar visible-md">
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


                <?php if ($this->beginCache('site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget', array('duration' => 300))) { $this->widget('site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget'); $this->endCache(); } ?>
            </aside>
        </div>
    </div>
<?php $this->endContent(); ?>