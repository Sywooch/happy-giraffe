<div style="margin: 15px 15px 15px 0;">
    <?php if ($data instanceof CommunityContent || ($data instanceof \site\frontend\modules\posts\models\Content && $data->originService == 'oldCommunity')): ?>
    <?php $widget = $this->beginWidget('AdsWidget', array('dummyTag' => 'yandex-direct')); ?>
    <!-- ﬂÌ‰ÂÍÒ.ƒËÂÍÚ -->
    <div id="yandex_ad_<?=$widget->id?>"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(87026, "yandex_ad_<?=$widget->id?>", {
                    stat_id: 26,
                    ad_format: "direct",
                    font_size: 1.1,
                    type: "vertical",
                    limit: 2,
                    title_font_size: 3,
                    links_underline: true,
                    site_bg_color: "FFFFFF",
                    title_color: "02B4F2",
                    url_color: "000000",
                    text_color: "000000",
                    hover_color: "63CDFF",
                    no_sitelinks: true
                });
            });
            t = d.getElementsByTagName("script")[0];
            s = d.createElement("script");
            s.src = "//an.yandex.ru/system/context.js";
            s.type = "text/javascript";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(window, document, "yandex_context_callbacks");
    </script>
    <?php $this->endWidget(); ?>
    <?php else: ?>
        <?php Yii::app()->controller->renderPartial('//banners/_direct_others'); ?>
    <?php endif; ?>
</div>