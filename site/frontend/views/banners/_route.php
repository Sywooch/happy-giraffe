<?php $this->beginWidget('AdsWidget'); ?>
<div class="adv-yandex">
    <!-- ﬂÌ‰ÂÍÒ.ƒËÂÍÚ -->
    <div id="yandex_ad_route"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(127976, "yandex_ad_route", {
                    ad_format: "direct",
                    font_size: 1.2,
                    type: "flat",
                    limit: 2,
                    title_font_size: 3,
                    site_bg_color: "FFFFFF",
                    title_color: "996EC2",
                    url_color: "006600",
                    text_color: "333333",
                    hover_color: "AC89CE",
                    favicon: true,
                    no_sitelinks: true
                });
            });
            t = d.getElementsByTagName('head')[0];
            s = d.createElement("script");
            s.src = "//an.yandex.ru/system/context.js";
            s.type = "text/javascript";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(window, document, "yandex_context_callbacks");
    </script>
</div>
<?php $this->endWidget(); ?>