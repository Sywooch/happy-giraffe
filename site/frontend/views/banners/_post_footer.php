<div style="margin: 15px;">
    <?php if (false && $data instanceof CommunityContent && ! $data->getIsFromBlog()): ?>
    <?php $this->beginWidget('AdsWidget'); ?>
    <!-- ﬂÌ‰ÂÍÒ.ƒËÂÍÚ -->
    <div id="yandex_ad_post_footer"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(87026, "yandex_ad_post_footer", {
                    ad_format: "direct",
                    font_size: 1.1,
                    type: "flat",
                    limit: 3,
                    title_font_size: 3,
                    site_bg_color: "FFFFFF",
                    title_color: "289FD7",
                    url_color: "006600",
                    text_color: "333333",
                    hover_color: "2289BA",
                    favicon: true,
                    no_sitelinks: true
                });
            });
            t = d.getElementsByTagName('head')[0];
            s = d.createElement("script");
            s.type = "text/javascript";
            s.src = "http://an.yandex.ru/system/context.js";
            s.setAttribute("async", "true");
            t.insertBefore(s, t.firstChild);
        })(window, document, "yandex_context_callbacks");
    </script>
    <?php $this->endWidget(); ?>
    <?php else: ?>
        <?php Yii::app()->controller->renderPartial('//banners/_route'); ?>
    <?php endif; ?>
</div>