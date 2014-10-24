<?php
$data = $this->user->getBlogData();
$data['currentRubricId'] = $this->rubric_id;
?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="content-cols clearfix">
        <div class="col-23-middle">
            <?php if (false): ?>
            <div class="blog-title-b blogInfo">
                <?php if ($this->user->id == Yii::app()->user->id): ?>
                    <a href="<?=$this->createUrl('settings/form')?>" class="blog-settings fancy powertip" title="Настройки блога"></a>
                <?php endif; ?>
                <div class="blog-title-b_img-hold" data-bind="if: photoThumbSrc() !== null">
                    <img alt="" class="blog-title-b_img" data-bind="attr: { src : photoThumbSrcToShow }">
                </div>
                <div class="blog-title-b_t" data-bind="text: title, visible: title().length > 0"><?=$data['title']?></div>
            </div>
            <?php endif; ?>

            <?=$content ?>
        </div>
        <div class="col-1">
            <?php if ($this->action->id == 'view'): ?>
                <?php $this->beginWidget('AdsWidget'); ?>
                <div class="banner">
                    <!--AdFox START-->
                    <!--giraffe-->
                    <!--Площадка: Весёлый Жираф / * / *-->
                    <!--Тип баннера: Безразмерный 240x400-->
                    <!--Расположение: &lt;сайдбар&gt;-->
                    <!-- ________________________AdFox Asynchronous code START__________________________ -->
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


                        var dl = escape(document.location);
                        var pr1 = Math.floor(Math.random() * 1000000);

                        document.write('<div id="AdFox_banner_'+pr1+'"><\/div>');
                        document.write('<div style="visibility:hidden; position:absolute;"><iframe id="AdFox_iframe_'+pr1+'" width=1 height=1 marginwidth=0 marginheight=0 scrolling=no frameborder=0><\/iframe><\/div>');

                        AdFox_getCodeScript(1,pr1,'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a&amp;pr=' + pr +'&amp;pt=b&amp;pd=' + addate.getDate() + '&amp;pw=' + addate.getDay() + '&amp;pv=' + addate.getHours() + '&amp;prr=' + afReferrer + '&amp;dl='+dl+'&amp;pr1='+pr1);
                        // -->
                    </script>
                    <!-- _________________________AdFox Asynchronous code END___________________________ -->
                </div>
                <?php $this->endWidget(); ?>
            <?php endif; ?>

            <?php $this->widget('Avatar', array('user' => $this->user, 'size' => 200, 'blog_link' => false, 'location' => true, 'age' => true)); ?>

            <div class="aside-blog-desc blogInfo" data-bind="visible: descriptionToShow().length > 0">
                <div class="aside-blog-desc_tx" data-bind="html: descriptionToShow"><?=$data['description']?></div>
            </div>

            <?php if ($this->action->id == 'view'): ?>
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
                <!--AdFox END-->
            <?php endif; ?>

            <?php Yii::beginProfile('subs'); ?>
            <?php $this->renderPartial('_subscribers'); ?>
            <?php Yii::endProfile('subs'); ?>

            <?php Yii::beginProfile('rubrics'); ?>
            <div class="menu-simple blogInfo" id="rubricsList" data-bind="visible: showRubrics">
                <?php $this->renderPartial('_rubric_list', array('currentRubricId' => $this->rubric_id)); ?>
            </div>
            <?php Yii::endProfile('rubrics'); ?>

            <?php if ($this->action->id == 'view'): ?>
                <?php $this->beginWidget('AdsWidget'); ?>
                <div class="banner">
                    <?php $this->renderPartial('//banners/_sidebar'); ?>
                </div>
                <?php $this->endWidget(); ?>
            <?php endif; ?>

            <?php if (false): ?>
            <?php Yii::beginProfile('popular'); ?>
            <?php $this->renderPartial('_popular'); ?>
            <?php Yii::endProfile('popular'); ?>
            <?php endif; ?>
        </div>
    
    </div>
<?php
$cs = Yii::app()->clientScript;
    if ($cs->useAMD)
    {
        $cs->registerAMD('blogVM', array('ko' => 'knockout', 'ko_blog' => 'ko_blog'), '
            blogVM = new BlogViewModel(' . CJSON::encode($data) . ');
            $(".blogInfo").each(function(index, el) {
                ko.applyBindings(blogVM, el);
            });');
    }
    else
    {
        $cs
            ->registerPackage('ko_blog')
            ->registerPackage('ko_upload');
        $cs->registerScript('blogVM', '
            blogVM = new BlogViewModel(' . CJSON::encode($data) . ');
            $(".blogInfo").each(function(index, el) {
                ko.applyBindings(blogVM, el);
            });');
    }
?>


<?php $this->endContent(); ?>