<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css?r=349'); ?>
			<div id="baby">
				<div class="content-box clearfix">
					<div class="main main-right">
						<div class="main-in">
                            <?php echo $content; ?>
						</div>
					</div>
					
					<div class="side-left">

						<div class="banner-box">
                            <div style="margin-bottom: 40px;">
                                <!--AdFox START-->
                                <!--giraffe-->
                                <!--Площадка: Весёлый Жираф / * / *-->
                                <!--Тип баннера: Безразмерный 240x400-->
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
                                    document.write('<scr' + 'ipt type="text/javascript" src="http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;pdw=' + scrwidth + '&amp;pdh=' + scrheight + '"><\/scr' + 'ipt>');
                                    // -->
                                </script>
                                <!--AdFox END-->
                            </div>
                            <?=$this->renderPartial('//_banner')?>
						</div>
						
					</div>
					
				</div>
			</div>
<?php $this->endContent(); ?>