<div style="margin: 15px;">
    <?php if ($data instanceof CommunityContent): ?>
    <?php $this->beginWidget('AdsWidget'); ?>
    <!-- ﬂÌ‰ÂÍÒ.ƒËÂÍÚ -->
    <div id="yandex_ad_footer"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(87026, "yandex_ad_footer", {
                    stat_id: 17,
                    ad_format: "direct",
                    font_size: 1.1,
                    type: "flat",
                    limit: 3,
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
            t = d.getElementsByTagName("head")[0];
            s = d.createElement("script");
            s.src = "//an.yandex.ru/system/context.js";
            s.type = "text/javascript";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(window, document, "yandex_context_callbacks");
    </script>
    <?php $this->endWidget(); ?>
    <?php else: ?>
        <?php Yii::app()->controller->renderPartial('//banners/_route'); ?>
    <?php endif; ?>
</div>